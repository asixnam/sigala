<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK KGB - {{ $sk->nomor_sk }} - {{ $pegawai->nama_lengkap ?? $usulan->nip }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tinos', 'Times New Roman', serif;
            background-color: #f1f5f9;
            color: #0f172a;
        }
        .font-sans-ui { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono-code { font-family: 'JetBrains Mono', monospace; }
        @media print {
            .no-print { display: none !important; }
            body { background-color: #ffffff !important; padding: 0 !important; }
            .page-container {
                box-shadow: none !important;
                border: none !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 12mm 18mm !important;
            }
            @page {
                size: A4 portrait;
                margin: 0;
            }
        }
    </style>
</head>
<body class="py-6 px-4">

    @php
        $verifyUrl = route('sk.verify', $sk->qr_code_token ?? $sk->id);
        $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=160x160&margin=0&data=' . urlencode($verifyUrl);
        $isTeknisi = ($formatSk ?? '') === 'teknisi' || ($pegawai->is_teknisi ?? false) || (isset($pegawai->jenis_pegawai) && strtolower($pegawai->jenis_pegawai) === 'teknisi');
    @endphp

    <!-- Action Toolbar (No Print) -->
    <div class="no-print max-w-4xl mx-auto mb-6 bg-slate-900 text-white p-4 rounded-2xl shadow-xl flex items-center justify-between font-sans-ui">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400 font-bold shrink-0">
                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h1 class="text-sm font-bold text-white flex items-center gap-2">
                    <span>{{ $isTeknisi ? 'Surat Keputusan KGB Teknisi' : 'Surat Kenaikan Gaji Berkala (Jabatan Guru)' }}</span>
                    <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 px-2 py-0.5 rounded-md font-mono">{{ $isTeknisi ? 'FORMAT TEKNISI' : 'FORMAT GURU' }}</span>
                </h1>
                <p class="text-xs text-slate-400">Nomor: <span class="font-mono-code text-emerald-400 font-bold">{{ $sk->nomor_sk }}</span></p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ $verifyUrl }}" target="_blank" class="bg-slate-800 hover:bg-slate-700 text-emerald-400 border border-emerald-500/30 px-3 py-2 rounded-xl text-xs font-semibold transition flex items-center space-x-1.5" title="Buka Halaman Hasil Scan QR">
                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                <span>Cek Hasil Scan QR</span>
            </a>
            <button onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 shadow-md">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan PDF</span>
            </button>
            <button onclick="window.close()" class="bg-slate-800 hover:bg-slate-700 text-slate-300 px-3 py-2 rounded-xl text-xs font-semibold transition">
                Tutup
            </button>
        </div>
    </div>

    <!-- Official Document Sheet (A4 Portrait Container) -->
    <div class="page-container max-w-4xl mx-auto bg-white p-8 sm:p-12 shadow-2xl border border-slate-200 rounded-sm text-slate-950 leading-relaxed text-sm sm:text-base">

        @if($isTeknisi)
            {{-- ========================================================================= --}}
            {{-- FORMAT 2: KEPUTUSAN SEKRETARIS DAERAH KABUPATEN BLORA (TEKNISI)          --}}
            {{-- ========================================================================= --}}

            <!-- Kop Garuda / Pemkab Blora -->
            <div class="text-center space-y-1 pb-4 mb-4 border-b-2 border-slate-950">
                <img src="{{ asset('img/logoblora.png') }}" alt="Lambang Kabupaten Blora" class="w-16 h-auto mx-auto object-contain mb-1">
                <h2 class="text-base sm:text-lg font-bold uppercase tracking-wider">Pemerintah Kabupaten Blora</h2>
                <h1 class="text-lg sm:text-xl font-extrabold uppercase tracking-wide">Keputusan Sekretaris Daerah Kabupaten Blora</h1>
                <div class="text-xs sm:text-sm font-semibold tracking-wider">NOMOR : {{ $sk->nomor_sk }}</div>
                <div class="text-xs sm:text-sm font-bold tracking-wide pt-1">
                    TENTANG<br>
                    KENAIKAN GAJI BERKALA<br>
                    SEKRETARIS DAERAH KABUPATEN BLORA
                </div>
            </div>

            <!-- Konsiderans Menimbang & Mengingat -->
            <div class="space-y-3 text-xs sm:text-sm text-justify">
                <table class="w-full border-collapse">
                    <tbody>
                        <tr class="align-top">
                            <td class="w-24 sm:w-28 py-1 font-bold">Menimbang</td>
                            <td class="w-4 py-1">:</td>
                            <td class="py-1">
                                Bahwa untuk melaksanakan ketentuan Pasal 4 Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 7 Tahun 2023 tentang Kenaikan Gaji Berkala dan Kenaikan Gaji Istimewa Pegawai Pemerintah dengan Perjanjian Kerja, perlu menetapkan Keputusan Sekretaris Daerah Kabupaten Blora tentang Kenaikan Gaji Berkala;
                            </td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-1 font-bold">Mengingat</td>
                            <td class="py-1">:</td>
                            <td class="py-1 space-y-1">
                                <ol class="list-decimal pl-4 space-y-1">
                                    <li>Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara (Lembaran Negara Republik Indonesia Tahun 2023 Nomor 141, Tambahan Lembaran Negara Republik Indonesia Nomor 6897);</li>
                                    <li>Peraturan Pemerintah Nomor 49 Tahun 2018 tentang Manajemen Pegawai Pemerintah dengan Perjanjian Kerja;</li>
                                    <li>Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 7 Tahun 2023 tentang Kenaikan Gaji Berkala dan Kenaikan Gaji Istimewa bagi Pegawai Pemerintah dengan Perjanjian Kerja;</li>
                                </ol>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center font-bold tracking-wider py-1">
                    MEMUTUSKAN :
                </div>

                <table class="w-full border-collapse">
                    <tbody>
                        <tr class="align-top">
                            <td class="w-24 sm:w-28 py-1 font-bold">Menetapkan</td>
                            <td class="w-4 py-1">:</td>
                            <td class="py-1"></td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-1 font-bold">KESATU</td>
                            <td class="py-1">:</td>
                            <td class="py-1">
                                Memberikan Kenaikan Gaji Berkala kepada Pegawai Pemerintah dengan Perjanjian Kerja di bawah ini :
                                
                                <div class="pt-2 pl-2 sm:pl-4 space-y-1">
                                    <table class="w-full text-xs sm:text-sm">
                                        <tbody>
                                            <tr class="align-top">
                                                <td class="w-56 py-0.5">1. Nama</td>
                                                <td class="w-3 py-0.5">:</td>
                                                <td class="py-0.5 font-bold">{{ $pegawai->nama_lengkap ?? $pegawai->nama }}</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="py-0.5">2. NIP</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5 font-mono-code font-bold">{{ $pegawai->nip }}</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="py-0.5">3. Golongan / Jabatan</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5 font-semibold">{{ $pegawai->pangkat_gol ?? 'V' }} / {{ $pegawai->jabatan ?? 'Operator Layanan Operasional' }}</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="py-0.5">4. Masa Perjanjian Kerja</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5">{{ $pegawai->masa_perjanjian_kerja ?? '01 September 2025 s.d. 2030' }}</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="py-0.5">5. Perpanjangan Perjanjian Kerja</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5">{{ $pegawai->perpanjangan_perjanjian_kerja ?? '-' }}</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="py-0.5">6. Unit Kerja</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5">{{ $pegawai->unit_kerja }}</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="py-0.5">7. Gaji Lama</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5 font-semibold">Rp. {{ number_format($pegawai->gaji_pokok_lama, 0, ',', '.') }},- ({{ $pegawai->dasar_peraturan ?? 'Perpres 11 Th. 2024' }})</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="pl-4 py-0.5 text-slate-700">a. Oleh pejabat</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5">{{ $pegawai->sk_terakhir_pejabat ?? 'Bupati Blora' }}</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="pl-4 py-0.5 text-slate-700">b. Tanggal</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5">{{ $pegawai->sk_terakhir_tgl ? date('d F Y', strtotime($pegawai->sk_terakhir_tgl)) : '29 Agustus 2025' }}</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="pl-4 py-0.5 text-slate-700">c. Nomor</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5 font-mono-code">{{ $pegawai->sk_terakhir_no ?? '800.1.25 / 285 / KEPEG / 2025' }}</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="pl-4 py-0.5 text-slate-700">d. Tanggal Berlaku Gaji tersebut</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5">{{ date('d F Y', strtotime($pegawai->tmt_kgb_terakhir ?? '2025-09-01')) }}</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="pl-4 py-0.5 text-slate-700">e. Masa kerja Gol. pada tanggal tsb.</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5">{{ sprintf('%02d', $pegawai->mkg_tahun) }} tahun {{ sprintf('%02d', $pegawai->mkg_bulan) }} bulan</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="py-0.5 font-bold">8. Gaji pokok baru</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5 font-extrabold text-slate-900 text-sm sm:text-base">Rp. {{ number_format($usulan->gaji_pokok_baru, 0, ',', '.') }},- ({{ $pegawai->dasar_peraturan ?? 'Perpres 11 Th. 2024' }})</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="py-0.5 font-semibold">9. Berdasarkan masa kerja</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5 font-semibold">{{ sprintf('%02d', $usulan->mkg_baru_tahun) }} tahun {{ sprintf('%02d', $usulan->mkg_baru_bulan) }} bulan</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="py-0.5 font-semibold">10. Dalam golongan</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5 font-semibold">{{ $pegawai->pangkat_gol ?? 'V' }}</td>
                                            </tr>
                                            <tr class="align-top">
                                                <td class="py-0.5 font-semibold">11. Mulai tanggal</td>
                                                <td class="py-0.5">:</td>
                                                <td class="py-0.5 font-bold">{{ date('d F Y', strtotime($usulan->tmt_berlaku)) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-1 font-bold">KEDUA</td>
                            <td class="py-1">:</td>
                            <td class="py-1">
                                Segala biaya yang diperlukan dalam rangka pelaksanaan Keputusan ini, dibebankan kepada Anggaran Pendapatan dan Belanja Daerah Pemerintah Kabupaten Blora.
                            </td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-1 font-bold">KETIGA</td>
                            <td class="py-1">:</td>
                            <td class="py-1">
                                Keputusan Sekretaris Daerah ini mulai berlaku sejak tanggal ditetapkan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tanda Tangan & QR Code TTE (Teknisi/PPPK) -->
            <div class="mt-8 pt-2 flex justify-end">
                <!-- Kolom Tanda Tangan a.n Sekda / Kadis SUNARYO -->
                <div class="text-center space-y-1 font-sans-ui min-w-[280px]">
                    <div class="text-xs">Ditetapkan di : Blora</div>
                    <div class="text-xs font-semibold">pada tanggal : {{ date('d F Y', strtotime($sk->tanggal_sk)) }}</div>
                    <div class="text-xs font-bold uppercase pt-1 leading-snug">
                        a.n SEKRETARIS DAERAH KABUPATEN BLORA<br>
                        KEPALA DINAS PENDIDIKAN KABUPATEN BLORA
                    </div>

                    <!-- Visual QR Code TTE Bersih Tanpa Teks Samping (Diperbesar) -->
                    <div class="py-2.5 flex justify-center items-center">
                        <a href="{{ $verifyUrl }}" target="_blank" class="p-1.5 border border-slate-300 rounded-2xl bg-white shadow-sm hover:border-emerald-600 hover:shadow-md transition inline-block" title="Scan / Klik untuk Validasi TTE">
                            <img src="{{ $qrApiUrl }}" alt="QR Code TTE" class="w-24 h-24 sm:w-28 sm:h-28 object-contain">
                        </a>
                    </div>

                    <div class="font-bold underline text-sm sm:text-base">SUNARYO</div>
                    <div class="text-xs text-slate-600">Pembina Utama Muda</div>
                    <div class="text-xs font-mono-code text-slate-600">NIP. 197003111994121002</div>
                </div>
            </div>

            <!-- Catatan Kecil Satu Baris di Pojok Kanan Bawah -->
            <div class="text-right text-[10px] text-slate-500 italic mt-3 font-sans-ui">
                * Dokumen ini telah ditandatangani secara elektronik resmi (BSrE - BSSN) | Token: <span class="font-mono-code">{{ $sk->qr_code_token ?? 'QR-SIGALA-PPPK' }}</span>
            </div>

            <!-- Tembusan Teknisi/PPPK -->
            <div class="mt-6 pt-3 border-t border-slate-200 text-xs text-slate-700">
                <div class="font-bold">Tembusan disampaikan Kepada Yth:</div>
                <ol class="list-decimal pl-4 space-y-0.5 mt-0.5">
                    <li>Kepala BKD Kabupaten Blora</li>
                    <li>Kepala BPPKAD Kabupaten Blora</li>
                    <li>Pegawai yang bersangkutan</li>
                </ol>
            </div>

        @else
            {{-- ========================================================================= --}}
            {{-- FORMAT 1: SURAT KENAIKAN GAJI BERKALA JABATAN GURU                        --}}
            {{-- ========================================================================= --}}

            <!-- Kop Surat Resmi Dinas Pendidikan Kab. Blora -->
            <div class="border-b-4 border-double border-slate-950 pb-4 mb-6">
                <div class="flex items-center space-x-5">
                    <div class="w-20 shrink-0 flex justify-center">
                        <img src="{{ asset('img/logoblora.png') }}" alt="Logo Kab. Blora" class="w-16 h-auto object-contain">
                    </div>
                    <div class="flex-1 text-center font-bold uppercase tracking-wide">
                        <div class="text-base sm:text-lg">Pemerintah Kabupaten Blora</div>
                        <div class="text-lg sm:text-2xl font-extrabold text-slate-900">Dinas Pendidikan</div>
                        <div class="text-xs sm:text-sm font-normal normal-case text-slate-700 mt-1">
                            Jalan Pemuda No. 44 Blora, Kode Pos 58215, Telepon (0296) 531123<br>
                            Laman: <span class="underline">dindik.blorakab.go.id</span> • Pos-el: dindik@blorakab.go.id
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header Surat & Penerima (Sesuai Format Jabatan Guru) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-4 text-xs sm:text-sm">
                <!-- Sisi Kiri: Nomor, Lampiran, Hal -->
                <table class="w-full">
                    <tbody>
                        <tr>
                            <td class="w-20 py-0.5">Nomor</td>
                            <td class="w-3 py-0.5">:</td>
                            <td class="py-0.5 font-mono-code font-bold">{{ $sk->nomor_sk }}</td>
                        </tr>
                        <tr>
                            <td class="py-0.5">Lampiran</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">-</td>
                        </tr>
                        <tr>
                            <td class="py-0.5">Hal</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5 font-bold">Kenaikan Gaji Berkala</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Sisi Kanan: Tempat, Tanggal & Tujuan Surat -->
                <div class="sm:text-left space-y-1 pl-0 sm:pl-8">
                    <div>Blora, {{ date('d F Y', strtotime($sk->tanggal_sk)) }}</div>
                    <div class="pt-1">
                        Kepada Yth.<br>
                        <strong>Kepala Badan Pendapatan Pengelolaan Keuangan dan Aset Daerah Kabupaten Blora</strong><br>
                        Di Blora
                    </div>
                </div>
            </div>

            <!-- Pembuka Surat -->
            <div class="my-4 text-justify text-xs sm:text-sm">
                <p>
                    Dengan ini diberitahukan bahwa berhubung telah dipenuhinya masa kerja dan syarat-syarat lainnya kepada :
                </p>
            </div>

            <!-- Data Pegawai Guru & Riwayat Gaji -->
            <div class="pl-2 sm:pl-4 my-3 text-xs sm:text-sm">
                <table class="w-full">
                    <tbody>
                        <tr class="align-top">
                            <td class="w-48 sm:w-56 py-0.5">1. Nama</td>
                            <td class="w-3 py-0.5">:</td>
                            <td class="py-0.5 font-bold text-slate-900">{{ $pegawai->nama_lengkap ?? $pegawai->nama }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-0.5">2. N I P</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5 font-mono-code font-bold">{{ $pegawai->nip }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-0.5">3. Tanggal Lahir</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">{{ $pegawai->tanggal_lahir ? date('d F Y', strtotime($pegawai->tanggal_lahir)) : '-' }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-0.5">4. Pangkat</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">{{ !empty($pegawai->pangkat_lengkap) ? $pegawai->pangkat_lengkap : 'Pembina Utama Muda (' . ($pegawai->pangkat_gol ?? 'IV/c') . ')' }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-0.5">5. Jabatan</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5 font-semibold">{{ $pegawai->jabatan ?? 'Guru Ahli Madya' }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-0.5">6. Kantor</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">{{ $pegawai->unit_kerja }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-0.5">7. Gaji Pokok</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5 font-semibold">Rp. {{ number_format($pegawai->gaji_pokok_lama, 0, ',', '.') }},-</td>
                        </tr>
                        <tr class="align-top">
                            <td colspan="3" class="pt-2 pb-1 font-semibold text-slate-800">
                                (Atas dasar Surat Keputusan Terakhir tentang gaji / pangkat yang ditetapkan) :
                            </td>
                        </tr>
                        <tr class="align-top">
                            <td class="pl-4 py-0.5 text-slate-700">a. Oleh Pejabat</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">{{ $pegawai->sk_terakhir_pejabat ?? 'Kepala Dinas Pendidikan Kabupaten Blora' }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="pl-4 py-0.5 text-slate-700">b. Tanggal</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">{{ $pegawai->sk_terakhir_tgl ? date('d F Y', strtotime($pegawai->sk_terakhir_tgl)) : '1 Oktober 2024' }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="pl-4 py-0.5 text-slate-700">c. Nomor</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5 font-mono-code">{{ $pegawai->sk_terakhir_no ?? '800.1.11.13.IV/1918' }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="pl-4 py-0.5 text-slate-700">d. Tanggal mulai berlakunya gaji tersebut</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">{{ date('d F Y', strtotime($pegawai->tmt_kgb_terakhir ?? '2024-12-01')) }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="pl-4 py-0.5 text-slate-700">e. Masa kerja golongan pada tanggal tsb.</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">{{ sprintf('%02d', $pegawai->mkg_tahun) }} tahun {{ sprintf('%02d', $pegawai->mkg_bulan) }} bulan</td>
                        </tr>
                        <tr class="align-top">
                            <td colspan="3" class="pt-2 pb-1 font-semibold text-slate-900">
                                Diberikan kenaikan gaji berkala hingga memperoleh :
                            </td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-0.5 font-bold">8. Gaji pokok baru</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5 font-extrabold text-slate-900 text-sm sm:text-base">Rp. {{ number_format($usulan->gaji_pokok_baru, 0, ',', '.') }},-</td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-0.5 font-semibold">9. Berdasarkan masa kerja</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5 font-semibold">{{ sprintf('%02d', $usulan->mkg_baru_tahun) }} tahun {{ sprintf('%02d', $usulan->mkg_baru_bulan) }} bulan</td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-0.5 font-semibold">10. Dalam golongan / ruang</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5 font-semibold">{{ $pegawai->pangkat_gol ?? 'IV/c' }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="py-0.5 font-semibold">11. Mulai tanggal</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5 font-bold">{{ date('d F Y', strtotime($usulan->tmt_berlaku)) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Penutup Surat Guru -->
            <div class="my-4 text-justify text-xs sm:text-sm">
                <p>
                    Diharapkan agar sesuai dengan {{ $pegawai->dasar_peraturan ?? 'Peraturan Pemerintah Nomor 5 Tahun 2024' }} kepada Pegawai tersebut dapat dibayarkan penghasilannya berdasarkan gaji pokok yang baru.
                </p>
            </div>

            <!-- Tanda Tangan Kadis SUNARYO & QR Code TTE -->
            <div class="mt-8 pt-2 flex justify-end">
                <!-- Kolom Tanda Tangan Kadis SUNARYO -->
                <div class="text-center space-y-1 font-sans-ui min-w-[280px]">
                    <div class="text-xs font-bold uppercase leading-snug">
                        Kepala Dinas Pendidikan<br>
                        Kabupaten Blora
                    </div>

                    <!-- Visual QR Code TTE Bersih Tanpa Teks Samping (Diperbesar) -->
                    <div class="py-2.5 flex justify-center items-center">
                        <a href="{{ $verifyUrl }}" target="_blank" class="p-1.5 border border-slate-300 rounded-2xl bg-white shadow-sm hover:border-emerald-600 hover:shadow-md transition inline-block" title="Scan / Klik untuk Validasi TTE">
                            <img src="{{ $qrApiUrl }}" alt="QR Code TTE" class="w-24 h-24 sm:w-28 sm:h-28 object-contain">
                        </a>
                    </div>

                    <div class="font-bold underline text-sm sm:text-base">SUNARYO, S.Pd., M.Si.</div>
                    <div class="text-xs text-slate-700">Pembina Utama Muda</div>
                    <div class="text-xs font-mono-code text-slate-600">NIP 197003111994121002</div>
                </div>
            </div>

            <!-- Catatan Kecil Satu Baris di Pojok Kanan Bawah -->
            <div class="text-right text-[10px] text-slate-500 italic mt-3 font-sans-ui">
                * Dokumen ini telah ditandatangani secara elektronik resmi (BSrE - BSSN) | Token: <span class="font-mono-code">{{ $sk->qr_code_token ?? 'QR-SIGALA-GURU' }}</span>
            </div>

            <!-- Tembusan Guru PNS -->
            <div class="mt-6 pt-3 border-t border-slate-200 text-xs text-slate-700">
                <div class="font-bold">Tembusan Kepada Yth :</div>
                <ol class="list-decimal pl-4 space-y-0.5 mt-0.5">
                    <li>Kepala BKPSDM Kabupaten Blora</li>
                    <li>Bendahara Gaji {{ $pegawai->unit_kerja }}</li>
                    <li>Pegawai yang bersangkutan</li>
                </ol>
            </div>
        @endif

    </div>

</body>
</html>
