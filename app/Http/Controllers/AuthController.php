<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman Landing Page / Login
    public function index()
    {
        $settings = json_decode(
            @file_get_contents(storage_path('app/settings.json')),
            true
        ) ?? [];

        $activeSessions = [];

        // Tampilkan semua sesi aktif dari masing‑masing guard
        foreach (['superadmin' => 'superadmin', 'admin_sekolah' => 'admin_sekolah', 'gtk' => 'gtk'] as $guardName => $guardKey) {
            if (Auth::guard($guardKey)->check()) {
                $u = Auth::guard($guardKey)->user();
                $role = $u->role;
                if (in_array($role, ['superadmin', 'admin_dinas', 'admin_tte'])) {
                    $label = 'Super Admin / Dinas';
                    $dashboard = route('admin.dashboard');
                } elseif ($role === 'admin_sekolah') {
                    $label = 'Admin Sekolah (' . ($u->unit_kerja ?? 'Sekolah') . ')';
                    $dashboard = route('sekolah.dashboard');
                } else {
                    $label = 'GTK (' . ($u->username ?? 'Pegawai') . ')';
                    $dashboard = route('gtk.dashboard');
                }

                $activeSessions[$guardKey] = [
                    'user' => $u,
                    'label' => $label,
                    'dashboard' => $dashboard,
                ];
            }
        }

        // Hitung total sekolah
        $totalSekolah = User::where('role', 'admin_sekolah')->count();

        if ($totalSekolah === 0) {
            $totalSekolah = Pegawai::whereNotNull('unit_kerja')
                ->where('unit_kerja', '!=', '')
                ->distinct('unit_kerja')
                ->count('unit_kerja');
        }

        // Hitung total guru / pegawai
        $totalGuru = Pegawai::count();

        return view(
            'auth.landing',
            compact(
                'settings',
                'activeSessions',
                'totalSekolah',
                'totalGuru'
            )
        );
    }

    // Proses Autentikasi Login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginInput = trim($credentials['username']);

        // Cari user berdasarkan Username, Email, atau NIP
        $user = User::where('username', $loginInput)
            ->orWhere('email', $loginInput)
            ->orWhere('nip_pegawai', $loginInput)
            ->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'username' => 'NIP, Email, atau Username tidak terdaftar dalam sistem.'
                ])
                ->withInput();
        }

        // Jika GTK / Pegawai, pastikan data pegawai tersedia
        if ($user->role === 'gtk') {

            $pegawai = Pegawai::where(
                'nip',
                $user->nip_pegawai
            )->first();

            if (!$pegawai) {
                return back()
                    ->withErrors([
                        'username' => 'Data pegawai tidak ditemukan pada database kepegawaian.'
                    ])
                    ->withInput();
            }
        }

        /*
         * Semua role menggunakan guard WEB.
         * Role hanya menentukan dashboard setelah login.
         */
        $remember = $request->boolean('remember');

        // Pilih guard yang sesuai berdasarkan role user
        $guardMap = [
            'superadmin'   => 'superadmin',
            'admin_dinas'  => 'superadmin',
            'admin_tte'    => 'superadmin',
            'admin_sekolah'=> 'admin_sekolah',
            'gtk'          => 'gtk',
        ];
        $guard = $guardMap[$user->role] ?? 'web';

        // Verifikasi password secara manual dan login ke guard yang tepat
        if (!\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors([
                    'username' => 'Kombinasi NIP/Email/Username dan Password tidak sesuai.',
                ])
                ->withInput();
        }

        // Login menggunakan guard yang dipilih
        Auth::guard($guard)->login($user, $remember);
        $request->session()->regenerate();

        // Set guard default untuk request ini
        Auth::shouldUse($guard);

        // Redirect berdasarkan role
        $role = Auth::user()->role;

        if (in_array($role, ['superadmin', 'admin_dinas', 'admin_tte'])) {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'admin_sekolah') {
            return redirect()->route('sekolah.dashboard');
        }

        return redirect()->route('gtk.dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        // Guard yang diminta dari form logout (hidden input)
        $validGuards = ['superadmin', 'admin_sekolah', 'gtk', 'web'];
        $guard = in_array($request->input('guard'), $validGuards)
            ? $request->input('guard')
            : 'web';

        // Logout hanya guard tersebut
        Auth::guard($guard)->logout();
        $request->session()->regenerateToken(); // refresh CSRF, tidak meng-invalidate semua sesi

        // Selalu arahkan ke halaman utama website (landing page),
        // sementara tab/role lain tetap aktif di dashboard masing-masing.
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}