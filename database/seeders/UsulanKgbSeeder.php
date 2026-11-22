<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UsulanKgb;
use App\Models\SkKgb;
use Illuminate\Support\Str;

class UsulanKgbSeeder extends Seeder
{
    /**
     * Run the database seeds for Usulan KGB records.
     */
    public function run(): void
    {
        $usulans = [
            [
                'nomor_usulan' => 'USULAN/KGB/2026/001',
                'nip' => '198505122010011001',
                'periode_bulan' => 8,
                'periode_tahun' => 2026,
                'gaji_pokok_baru' => 4450000.00,
                'mkg_baru_tahun' => 14,
                'mkg_baru_bulan' => 6,
                'tmt_berlaku' => '2026-08-01',
                'status' => 'verifikasi',
                'catatan_admin' => 'Dokumen SK terakhir dan SPMT sudah verifikasi lengkap.',
            ],
            [
                'nomor_usulan' => 'USULAN/KGB/2026/002',
                'nip' => '198205122008012011',
                'periode_bulan' => 8,
                'periode_tahun' => 2026,
                'gaji_pokok_baru' => 4050000.00,
                'mkg_baru_tahun' => 12,
                'mkg_baru_bulan' => 2,
                'tmt_berlaku' => '2026-08-01',
                'status' => 'verifikasi',
                'catatan_admin' => 'Sedang dalam verifikasi berkas oleh Tim Dinas.',
            ],
            [
                'nomor_usulan' => 'USULAN/KGB/2026/003',
                'nip' => '197912032005011003',
                'periode_bulan' => 8,
                'periode_tahun' => 2026,
                'gaji_pokok_baru' => 5200000.00,
                'mkg_baru_tahun' => 20,
                'mkg_baru_bulan' => 0,
                'tmt_berlaku' => '2026-08-01',
                'status' => 'tte',
                'catatan_admin' => 'Berkas disetujui, menunggu Tanda Tangan Elektronik Kadis.',
            ],
            [
                'nomor_usulan' => 'USULAN/KGB/2026/004',
                'nip' => '198803212011012004',
                'periode_bulan' => 9,
                'periode_tahun' => 2026,
                'gaji_pokok_baru' => 3450000.00,
                'mkg_baru_tahun' => 10,
                'mkg_baru_bulan' => 4,
                'tmt_berlaku' => '2026-09-01',
                'status' => 'selesai',
                'catatan_admin' => 'SK KGB telah terbit dan disahkan TTE BSrE.',
            ],
            [
                'nomor_usulan' => 'USULAN/KGB/2026/005',
                'nip' => '197804102003121005',
                'periode_bulan' => 8,
                'periode_tahun' => 2026,
                'gaji_pokok_baru' => 4700000.00,
                'mkg_baru_tahun' => 16,
                'mkg_baru_bulan' => 8,
                'tmt_berlaku' => '2026-08-01',
                'status' => 'tte',
                'catatan_admin' => 'Proses validasi TTE.',
            ],
            [
                'nomor_usulan' => 'USULAN/KGB/2026/006',
                'nip' => '198509152010012002',
                'periode_bulan' => 6,
                'periode_tahun' => 2026,
                'gaji_pokok_baru' => 4350000.00,
                'mkg_baru_tahun' => 14,
                'mkg_baru_bulan' => 0,
                'tmt_berlaku' => '2026-06-01',
                'status' => 'selesai',
                'catatan_admin' => 'SK KGB telah selesai dan diunduh.',
            ],
            [
                'nomor_usulan' => 'USULAN/KGB/2026/GURU-TUTIK',
                'nip' => '196809281994122006',
                'periode_bulan' => 12,
                'periode_tahun' => 2026,
                'gaji_pokok_baru' => 5687200.00,
                'mkg_baru_tahun' => 30,
                'mkg_baru_bulan' => 0,
                'tmt_berlaku' => '2026-12-01',
                'status' => 'selesai',
                'catatan_admin' => 'SK KGB Jabatan Guru telah disahkan TTE Kadis Pendidikan Kab. Blora.',
                'custom_sk' => [
                    'nomor_sk' => '800.1.11.13/VI',
                    'format_sk' => 'guru',
                    'tanggal_sk' => '2026-10-01',
                    'penandatangan_nama' => 'SUNARYO, S.Pd., M.Si.',
                    'penandatangan_nip' => '197003111994121002',
                    'penandatangan_pangkat' => 'Pembina Utama Muda',
                    'penandatangan_jabatan' => 'Kepala Dinas Pendidikan Kabupaten Blora',
                    'qr_code_token' => 'QR-SIGALA-GURU-196809281994122006',
                ]
            ],
            [
                'nomor_usulan' => 'USULAN/KGB/2026/PPPK-JUWARIADIN',
                'nip' => '198807102025211065',
                'periode_bulan' => 9,
                'periode_tahun' => 2026,
                'gaji_pokok_baru' => 2551100.00,
                'mkg_baru_tahun' => 1,
                'mkg_baru_bulan' => 0,
                'tmt_berlaku' => '2026-09-01',
                'status' => 'selesai',
                'catatan_admin' => 'SK KGB PPPK telah disahkan a.n Sekda oleh Kadis Pendidikan Kab. Blora.',
                'custom_sk' => [
                    'nomor_sk' => '800.1.11.3/V/1036/2026',
                    'format_sk' => 'pppk',
                    'tanggal_sk' => '2026-07-02',
                    'penandatangan_nama' => 'SUNARYO',
                    'penandatangan_nip' => '197003111994121002',
                    'penandatangan_pangkat' => 'Pembina Utama Muda',
                    'penandatangan_jabatan' => 'a.n SEKRETARIS DAERAH KABUPATEN BLORA KEPALA DINAS PENDIDIKAN KABUPATEN BLORA',
                    'qr_code_token' => 'QR-SIGALA-PPPK-198807102025211065',
                ]
            ],
        ];

        foreach ($usulans as $data) {
            $customSk = $data['custom_sk'] ?? null;
            unset($data['custom_sk']);

            $u = UsulanKgb::updateOrCreate(['nomor_usulan' => $data['nomor_usulan']], $data);

            if ($u->status === 'selesai') {
                $skData = [
                    'nomor_sk' => $customSk['nomor_sk'] ?? ('822.3 / ' . rand(1000, 9999) . ' / 2026'),
                    'format_sk' => $customSk['format_sk'] ?? 'guru',
                    'tanggal_sk' => $customSk['tanggal_sk'] ?? $u->tmt_berlaku,
                    'penandatangan_nama' => $customSk['penandatangan_nama'] ?? 'SUNARYO, S.Pd., M.Si.',
                    'penandatangan_nip' => $customSk['penandatangan_nip'] ?? '197003111994121002',
                    'penandatangan_pangkat' => $customSk['penandatangan_pangkat'] ?? 'Pembina Utama Muda',
                    'penandatangan_jabatan' => $customSk['penandatangan_jabatan'] ?? 'Kepala Dinas Pendidikan Kabupaten Blora',
                    'file_pdf_path' => 'sk_kgb_' . $u->nip . '.pdf',
                    'file_tte_path' => 'sk_kgb_' . $u->nip . '_signed.pdf',
                    'status_tte' => 'signed',
                    'qr_code_token' => $customSk['qr_code_token'] ?? ('QR-SIGALA-' . strtoupper(Str::random(12))),
                ];

                SkKgb::updateOrCreate(
                    ['usulan_id' => $u->id],
                    $skData
                );
            }
        }
    }
}
