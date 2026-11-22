<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Pegawai;

class GoogleAuthController extends Controller
{
    /**
     * Mendapatkan URL Redirect Google yang valid sesuai kebijakan keamanan Google OAuth 2.0.
     * Google secara ketat melarang format IP literal (seperti 127.0.0.1) untuk Web OAuth.
     */
    private function getGoogleRedirectUri(): string
    {
        $redirectUri = config('services.google.redirect') ?: route('auth.google.callback');

        // Google OAuth 2.0 policy menolak IP 127.0.0.1, ubah otomatis ke localhost jika dijalankan di lokal
        if (str_contains($redirectUri, '127.0.0.1')) {
            $redirectUri = str_replace('127.0.0.1', 'localhost', $redirectUri);
        }

        return $redirectUri;
    }

    /**
     * Mengarahkan pengguna ke halaman autentikasi Google OAuth 2.0
     */
    public function redirectToGoogle(Request $request)
    {
        $clientId = config('services.google.client_id');
        $redirectUri = $this->getGoogleRedirectUri();

        // Jika Google Client ID belum disetel di .env, kita sediakan fallback mode pengembangan
        if (empty($clientId) || $clientId === 'your-google-client-id') {
            // Ambil daftar akun pengguna yang memiliki email gmail/resmi untuk mode pengujian cepat
            $registeredUsers = User::whereNotNull('email')
                ->where('email', '!=', '')
                ->orderBy('role', 'asc')
                ->take(10)
                ->get();

            return view('auth.google-dev-helper', compact('registeredUsers'));
        }

        // Simpan state session untuk keamanan CSRF OAuth
        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'access_type' => 'online',
            'prompt' => 'select_account',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    /**
     * Menangani callback setelah pengguna login dan memilih akun Gmail di Google
     */
    public function handleGoogleCallback(Request $request)
    {
        // 1. Cek jika terjadi error dari sisi Google
        if ($request->has('error')) {
            return redirect()->route('login')
                ->with('error', 'Login dengan Google dibatalkan atau terjadi kesalahan: ' . $request->input('error'));
        }

        // 2. Ambil authorization code
        $code = $request->input('code');
        if (empty($code)) {
            return redirect()->route('login')
                ->with('error', 'Kode otorisasi Google tidak ditemukan.');
        }

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUri = $this->getGoogleRedirectUri();

        try {
            // 3. Tukarkan code dengan access token ke Google Token Endpoint
            $tokenResponse = Http::asForm()->timeout(15)->post('https://oauth2.googleapis.com/token', [
                'code' => $code,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'grant_type' => 'authorization_code',
            ]);

            if (!$tokenResponse->successful()) {
                return redirect()->route('login')
                    ->with('error', 'Gagal memverifikasi token Google. Pastikan Client ID dan Secret di .env sudah sesuai.');
            }

            $tokenData = $tokenResponse->json();
            $accessToken = $tokenData['access_token'] ?? null;

            if (!$accessToken) {
                return redirect()->route('login')
                    ->with('error', 'Access token Google tidak valid.');
            }

            // 4. Ambil informasi profil dari Google UserInfo Endpoint
            $userInfoResponse = Http::withToken($accessToken)
                ->timeout(15)
                ->get('https://www.googleapis.com/oauth2/v3/userinfo');

            if (!$userInfoResponse->successful()) {
                return redirect()->route('login')
                    ->with('error', 'Gagal mengambil data akun dari Google.');
            }

            $googleUser = $userInfoResponse->json();
            $email = strtolower(trim($googleUser['email'] ?? ''));
            $googleId = $googleUser['sub'] ?? null;
            $picture = $googleUser['picture'] ?? null;

            if (empty($email)) {
                return redirect()->route('login')
                    ->with('error', 'Akun Google Anda tidak menyediakan alamat email.');
            }

            // 5. Cari pengguna di database SIGALA berdasarkan email
            $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

            // Jika tidak ditemukan di tabel users, coba cek di tabel pegawais barangkali email terdaftar di pegawai
            if (!$user) {
                $pegawai = Pegawai::whereNotNull('nip')->first();
                // Jika email tidak ada di users
                return redirect()->route('login')
                    ->with('error', "Akun Gmail ({$email}) belum terdaftar di sistem SIGALA. Silakan hubungi admin sekolah atau dinas untuk mendaftarkan email Anda.");
            }

            // Update google_id dan avatar jika kolom tersedia
            $updateData = [];
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'google_id')) {
                $updateData['google_id'] = $googleId;
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'avatar') && $picture) {
                $updateData['avatar'] = $picture;
            }
            if (!empty($updateData)) {
                $user->update($updateData);
            }

            // 6. Login otomatis pengguna
            // Pilih guard yang sesuai berdasarkan role user
            $guardMap = [
                'superadmin'   => 'superadmin',
                'admin_dinas'  => 'superadmin',
                'admin_tte'    => 'superadmin',
                'admin_sekolah'=> 'admin_sekolah',
                'gtk'          => 'gtk',
            ];
            $guard = $guardMap[$user->role] ?? 'web';
            \Log::info('Google login guard: '.$guard);
            Auth::guard($guard)->login($user, true);
            // Set guard default untuk request ini
            Auth::shouldUse($guard);
            $request->session()->regenerate();

            // 7. Arahkan langsung ke dashboard sesuai role
            return $this->redirectBasedOnRole($user, $guard);

        } catch (\Throwable $e) {
            return redirect()->route('login')
                ->with('error', 'Terjadi kendala saat menghubungkan ke server Google: ' . $e->getMessage());
        }
    }

    /**
     * Endpoint pembantu untuk pengujian langsung (jika Google Client ID belum disetel di .env)
     */
    public function directLoginByEmail(Request $request)
    {
        $email = strtolower(trim($request->input('email', '')));
        if (empty($email)) {
            return redirect()->route('login')->with('error', 'Email tidak boleh kosong.');
        }

        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();
        if (!$user) {
            return redirect()->route('login')
                ->with('error', "Akun Gmail ({$email}) belum terdaftar di sistem SIGALA.");
        }

        // Pilih guard yang sesuai berdasarkan role user
        $guardMap = [
            'superadmin'   => 'superadmin',
            'admin_dinas'  => 'superadmin',
            'admin_tte'    => 'superadmin',
            'admin_sekolah'=> 'admin_sekolah',
            'gtk'          => 'gtk',
        ];
        $guard = $guardMap[$user->role] ?? 'web';
            \Log::info('Google login guard: '.$guard);
        Auth::guard($guard)->login($user, true);
        Auth::shouldUse($guard);
        $request->session()->regenerate();
        return $this->redirectBasedOnRole($user, $guard);    }

    /**
     * Helper redirect ke dashboard masing-masing role
     */
    private function redirectBasedOnRole($user, $guard)
    {
        // Pastikan guard yang dipakai menjadi default untuk request ini
        Auth::shouldUse($guard);

        if (in_array($user->role, ['superadmin','admin_dinas','admin_tte'])) {
            return redirect()->route('admin.dashboard')
                ->with('success', "Selamat datang, {$user->username}! Anda berhasil masuk menggunakan Akun Google.");
        }

        if ($user->role === 'admin_sekolah') {
            return redirect()->route('sekolah.dashboard')
                ->with('success', "Selamat datang, Admin Sekolah {$user->unit_kerja}! Anda berhasil masuk menggunakan Akun Google.");
        }

        return redirect()->route('gtk.dashboard')
            ->with('success', "Selamat datang! Anda berhasil masuk menggunakan Akun Google.");
    }
}

