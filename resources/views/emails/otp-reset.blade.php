<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Kata Sandi - SIGALA</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; margin: 0; padding: 24px; color: #1e293b;">

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 580px; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
        
        <!-- Header -->
        <tr>
            <td style="background: linear-gradient(135deg, #059669 0%, #047857 100%); padding: 32px 24px; text-align: center; color: #ffffff;">
                <h1 style="margin: 0; font-size: 24px; font-weight: 800; letter-spacing: 0.5px;">SIGALA KAB. BLORA</h1>
                <p style="margin: 6px 0 0 0; font-size: 13px; opacity: 0.9;">Sistem Informasi Kenaikan Gaji Berkala - Dinas Pendidikan</p>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 32px 28px;">
                <h2 style="margin: 0 0 12px 0; font-size: 18px; color: #0f172a; font-weight: 700;">Halo, {{ $user->username }}</h2>
                <p style="margin: 0 0 20px 0; font-size: 14px; line-height: 1.6; color: #475569;">
                    Kami menerima permintaan untuk menyetel ulang kata sandi akun SIGALA Anda. Gunakan kode verifikasi (OTP) berikut untuk melanjutkan proses pembuatan kata sandi baru:
                </p>

                <!-- Box Kode OTP -->
                <div style="background-color: #ecfdf5; border: 2px dashed #10b981; border-radius: 16px; padding: 24px; text-align: center; margin: 24px 0;">
                    <div style="font-size: 11px; font-weight: 700; color: #047857; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">KODE VERIFIKASI RESMI</div>
                    <div style="font-family: 'Courier New', Courier, monospace; font-size: 38px; font-weight: 900; color: #065f46; letter-spacing: 10px; margin: 0;">{{ $otp }}</div>
                    <div style="font-size: 12px; color: #059669; margin-top: 10px; font-weight: 500;">Berlaku selama 15 menit</div>
                </div>

                <!-- Peringatan Keamanan -->
                <div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 14px 16px; border-radius: 8px; margin: 20px 0;">
                    <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #92400e;">
                        <strong>Penting:</strong> Jangan berikan kode ini kepada siapa pun, termasuk pihak yang mengatasnamakan admin dinas atau sekolah. Jika Anda tidak meminta kode ini, abaikan email ini dan akun Anda tetap aman.
                    </p>
                </div>

                <p style="margin: 24px 0 0 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                    Salam hangat,<br>
                    <strong>Tim Pengembang SIGALA</strong><br>
                    Dinas Pendidikan Kabupaten Blora
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f8fafc; padding: 18px 24px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 11px; color: #94a3b8;">
                Dokumen pemberitahuan otomatis ini dikirim oleh server SIGALA. Mohon tidak membalas email ini.
            </td>
        </tr>

    </table>

</body>
</html>

