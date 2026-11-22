<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Pegawai;

class ForgotPasswordController extends Controller
{
    /**
     * Mengirimkan 6 Digit Kode OTP ke Gmail Pengguna
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
        ], [
            'identifier.required' => 'Email, NIP, atau Username wajib diisi.',
        ]);

        $input = trim($request->input('identifier'));

        // Cari user berdasarkan email, username, atau NIP pegawai
        $user = User::where('email', $input)
            ->orWhere('username', $input)
            ->orWhere('nip_pegawai', $input)
            ->first();

        // Jika belum ketemu dan input adalah NIP, cek apakah ada di tabel pegawai
        if (!$user) {
            $pegawai = Pegawai::where('nip', $input)->first();
            if ($pegawai && !empty($pegawai->nip)) {
                $user = User::where('nip_pegawai', $pegawai->nip)->first();
            }
        }

        if (!$user || empty($user->email)) {
            return response()->json([
                'success' => false,
                'message' => 'Akun dengan NIP / Email / Username tersebut tidak ditemukan atau belum memiliki alamat email yang terdaftar.',
            ], 404);
        }

        // Generate 6 Digit Angka OTP Acak
        $otp = (string) rand(100000, 999999);
        $expiresAt = now()->addMinutes(15);

        // Simpan ke database
        $user->reset_otp = $otp;
        $user->reset_otp_expires_at = $expiresAt;
        $user->save();

        // Sensor email untuk privasi tampilan, misal su****@gmail.com
        $emailParts = explode('@', $user->email);
        $namePart = $emailParts[0];
        $domainPart = $emailParts[1] ?? 'gmail.com';
        $maskedName = substr($namePart, 0, 2) . str_repeat('*', max(1, strlen($namePart) - 3)) . substr($namePart, -1);
        $maskedEmail = $maskedName . '@' . $domainPart;

        // Kirim Email OTP
        $emailSent = false;
        try {
            Mail::send('emails.otp-reset', ['user' => $user, 'otp' => $otp], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Kode OTP Verifikasi Reset Kata Sandi - SIGALA Kab. Blora');
            });
            $emailSent = true;
        } catch (\Throwable $e) {
            Log::warning('Pengiriman email OTP SIGALA gagal: ' . $e->getMessage());
            // Tetap izinkan flow berlanjut (khusus mode lokal/dev kita sertakan OTP di dev feedback)
        }

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP berhasil dikirimkan ke email Anda (' . $maskedEmail . '). Silakan periksa kotak masuk atau folder spam Gmail Anda.',
            'masked_email' => $maskedEmail,
            'identifier' => $user->email,
            // Jika mode lokal/testing dan email tidak terkirim via SMTP, sertakan petunjuk aman
            'dev_otp' => app()->environment('local') || config('mail.default') === 'log' ? $otp : null,
        ]);
    }

    /**
     * Memverifikasi Kode OTP dan Mereset Kata Sandi Baru
     */
    public function resetPasswordWithOtp(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'otp' => 'required|string|size:6',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'identifier.required' => 'Identitas akun tidak ditemukan.',
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus berupa 6 digit angka.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $input = trim($request->input('identifier'));
        $otp = trim($request->input('otp'));

        $user = User::where('email', $input)
            ->orWhere('username', $input)
            ->orWhere('nip_pegawai', $input)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Akun pengguna tidak ditemukan.',
            ], 404);
        }

        // Periksa apakah OTP cocok
        if (empty($user->reset_otp) || $user->reset_otp !== $otp) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP yang Anda masukkan salah. Silakan periksa kembali email Anda.',
            ], 422);
        }

        // Periksa apakah OTP kedaluwarsa
        if (!$user->reset_otp_expires_at || now()->greaterThan($user->reset_otp_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP telah kedaluwarsa (masa berlaku 15 menit). Silakan minta kode OTP baru.',
            ], 422);
        }

        // Update password baru & bersihkan OTP
        $user->password = Hash::make($request->input('password'));
        $user->reset_otp = null;
        $user->reset_otp_expires_at = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Kata sandi baru berhasil disimpan! Silakan masuk menggunakan kata sandi baru Anda.',
        ]);
    }
}

