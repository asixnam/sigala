<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi TTE Resmi - {{ $sk->nomor_sk }} - Dinas Pendidikan Kab. Blora</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logoblora.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono-code { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 min-h-screen text-slate-100 py-6 px-4 sm:px-6 flex flex-col justify-between">

    <!-- Top Navigation / Brand -->
    <header class="max-w-3xl mx-auto w-full mb-6">
        <div class="flex items-center justify-between bg-slate-900/70 backdrop-blur-md border border-slate-700/60 p-4 rounded-2xl shadow-lg">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('img/logoblora.png') }}" alt="Logo Kab Blora" class="w-10 h-10 object-contain">
                <div>
                    <h1 class="text-sm font-bold text-white tracking-wide">Pemerintah Kabupaten Blora</h1>
                    <p class="text-[11px] text-emerald-400 font-medium">Layanan Verifikasi Dokumen & TTE Resmi (SIGALA)</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center space-x-2 bg-emerald-500/10 border border-emerald-500/30 px-3 py-1.5 rounded-xl text-emerald-400 text-xs font-semibold">
                <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>BSrE - BSSN Terverifikasi</span>
            </div>
        </div>
    </header>

    <!-- Main Verification Content Card -->
    <main class="max-w-3xl mx-auto w-full bg-white text-slate-900 rounded-3xl shadow-2xl border border-slate-200 overflow-hidden mb-6">
        
        <!-- Header Banner: Validitas TTE -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-700 text-white p-6 sm:p-8 text-center relative overflow-hidden">
            <div class="relative z-10 space-y-2">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl mx-auto flex items-center justify-center border border-white/30 shadow-inner mb-3">
                    <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-white/20 text-emerald-100 border border-white/20">
                    STATUS: ASLI & TERVERIFIKASI
                </span>
                <h2 class="text-xl sm:text-2xl font-black tracking-tight">TANDA TANGAN ELEKTRONIK (TTE) SAH</h2>
                <p class="text-emerald-100 text-xs sm:text-sm max-w-lg mx-auto">
                    Surat Keputusan Kenaikan Gaji Berkala ini telah ditandatangani secara elektronik resmi oleh Pejabat yang berwenang menggunakan Sertifikat Elektronik BSrE.
                </p>
            </div>
            <!-- Decorative Glow -->
            <div class="absolute -right-12 -bottom-12 w-44 h-44 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -left-12 -top-12 w-44 h-44 bg-emerald-400/20 rounded-full blur-2xl pointer-events-none"></div>
        </div>

        <div class="p-6 sm:p-8 space-y-6">

            <!-- Card 1: Penandatangan Resmi (Kadis SUNARYO) -->
            <div class="bg-emerald-50/70 border border-emerald-200 rounded-2xl p-5 space-y-3">
                <div class="flex items-center space-x-2 text-emerald-900 font-bold text-xs uppercase tracking-wider">
                    <svg class="w-4 h-4 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Identitas Penandatangan TTE</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm">
                    <div>
                        <span class="text-slate-500 text-xs block">Nama Pejabat Penandatangan:</span>
                        <strong class="text-slate-900 text-base font-extrabold text-emerald-950">{{ $penandatangan['nama'] ?? 'SUNARYO, S.Pd., M.Si.' }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">NIP Pejabat:</span>
                        <strong class="font-mono-code text-slate-800">{{ $penandatangan['nip'] ?? '197003111994121002' }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Pangkat / Golongan:</span>
                        <strong class="text-slate-800">{{ $penandatangan['pangkat'] ?? 'Pembina Utama Muda' }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Jabatan Pengesah:</span>
                        <strong class="text-slate-800">{{ $penandatangan['jabatan'] ?? 'Kepala Dinas Pendidikan Kabupaten Blora' }}</strong>
                    </div>
                </div>
                <div class="pt-2 border-t border-emerald-200/80 flex items-center justify-between flex-wrap gap-2 text-[11px] text-emerald-800">
                    <div class="flex items-center space-x-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Sertifikat Digital: <strong>Balai Sertifikasi Elektronik (BSrE) - BSSN</strong></span>
                    </div>
                    <div>
                        Tanggal TTE: <strong>{{ date('d F Y', strtotime($sk->tanggal_sk)) }}</strong>
                    </div>
                </div>
            </div>

            <!-- Card 2: Ringkasan Dokumen SK KGB -->
            <div class="space-y-3">
                <div class="flex items-center space-x-2 text-slate-800 font-bold text-xs uppercase tracking-wider">
                    <svg class="w-4 h-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Informasi Surat Keputusan</span>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5 divide-y divide-slate-200/70 text-xs sm:text-sm">
                    <div class="py-2.5 flex justify-between flex-wrap gap-1">
                        <span class="text-slate-500">Nomor Dokumen SK</span>
                        <span class="font-mono-code font-bold text-slate-900 bg-white px-2.5 py-0.5 rounded-lg border border-slate-200">{{ $sk->nomor_sk }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between flex-wrap gap-1">
                        <span class="text-slate-500">Format & Jenis SK</span>
                        <span class="font-semibold text-slate-900">
                            @if($formatSk === 'pppk')
                                Keputusan Sekretaris Daerah Kab. Blora (PPPK)
                            @else
                                Surat Kenaikan Gaji Berkala Jabatan Guru (PNS)
                            @endif
                        </span>
                    </div>
                    <div class="py-2.5 flex justify-between flex-wrap gap-1">
                        <span class="text-slate-500">Nama Penerima / Pegawai</span>
                        <span class="font-bold text-slate-900">{{ $pegawai->nama_lengkap ?? $usulan->nip }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between flex-wrap gap-1">
                        <span class="text-slate-500">NIP Penerima</span>
                        <span class="font-mono-code text-slate-800 font-semibold">{{ $pegawai->nip }}</span>
                    </div>
                    @if(!empty($pegawai->jabatan))
                    <div class="py-2.5 flex justify-between flex-wrap gap-1">
                        <span class="text-slate-500">Jabatan</span>
                        <span class="font-semibold text-slate-800">{{ $pegawai->jabatan }}</span>
                    </div>
                    @endif
                    <div class="py-2.5 flex justify-between flex-wrap gap-1">
                        <span class="text-slate-500">Satuan Pendidikan / Unit Kerja</span>
                        <span class="font-semibold text-slate-800">{{ $pegawai->unit_kerja ?? '-' }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between flex-wrap gap-1">
                        <span class="text-slate-500">Gaji Pokok Baru</span>
                        <span class="font-black text-emerald-700 text-base">Rp {{ number_format($usulan->gaji_pokok_baru, 0, ',', '.') }},-</span>
                    </div>
                    <div class="py-2.5 flex justify-between flex-wrap gap-1">
                        <span class="text-slate-500">Masa Kerja Golongan (MKG) Baru</span>
                        <span class="font-semibold text-slate-800">{{ $usulan->mkg_baru_tahun }} Tahun {{ sprintf('%02d', $usulan->mkg_baru_bulan) }} Bulan</span>
                    </div>
                    <div class="py-2.5 flex justify-between flex-wrap gap-1">
                        <span class="text-slate-500">Terhitung Mulai Tanggal (TMT)</span>
                        <span class="font-bold text-slate-900">{{ date('d F Y', strtotime($usulan->tmt_berlaku)) }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between items-center flex-wrap gap-1">
                        <span class="text-slate-500">Token Digital TTE</span>
                        <span class="font-mono-code text-xs text-slate-600 bg-slate-200/60 px-2 py-0.5 rounded">{{ $sk->qr_code_token }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center gap-3 pt-2">
                <a href="{{ route('sk.preview', $sk->id) }}" target="_blank" class="w-full sm:flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl text-center text-xs sm:text-sm transition shadow-md flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>Buka Petikan SK Resmi (PDF)</span>
                </a>
                <a href="{{ route('sk.download', $sk->id) }}" class="w-full sm:flex-1 bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-4 rounded-xl text-center text-xs sm:text-sm transition shadow-md flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Unduh Dokumen SK</span>
                </a>
            </div>

        </div>

        <!-- Footer Verification Note -->
        <div class="p-4 bg-slate-100 border-t border-slate-200 text-center text-xs text-slate-500 space-y-1">
            <p>Dokumen ini diterbitkan secara sah melalui Sistem Informasi Kenaikan Gaji Berkala (SIGALA) Dinas Pendidikan Kabupaten Blora.</p>
            <p class="text-[11px] text-slate-400">Verifikasi publik ini dilindungi oleh UU ITE No. 1 Tahun 2024 dan Peraturan BSSN No. 10 Tahun 2020.</p>
        </div>

    </main>

    <!-- Footer Page -->
    <footer class="max-w-3xl mx-auto w-full text-center text-xs text-slate-400 py-2">
        &copy; {{ date('Y') }} Dinas Pendidikan Kabupaten Blora • Sistem Informasi Kenaikan Gaji Berkala (SIGALA)
    </footer>

</body>
</html>

