<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard GTK - SIGALA Dinas Pendidikan Kab. Blora</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logoblora.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- 1. SIDEBAR NAVIGATION -->
        @include('layouts.gtk-navigation')

        <!-- 2. MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Header -->
            <x-top-header 
                title="Dashboard Guru & Tenaga Kependidikan" 
                titleMobile="Dashboard GTK" 
                :badge="$pegawai->unit_kerja ?? 'Satuan Pendidikan'" 
            />

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-4 sm:p-6">
                <div class="max-w-7xl mx-auto space-y-6">

                    <!-- Welcome Banner -->
                    <div class="relative overflow-hidden bg-emerald-600/85 backdrop-blur-xl border border-white/25 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-emerald-900/10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="space-y-1.5 relative z-10">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-emerald-50 text-[10px] sm:text-xs font-bold uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-yellow-300 animate-pulse"></span>
                                Portal Pegawai GTK
                            </div>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-white drop-shadow-sm pt-0.5">Selamat Datang, {{ $pegawai->nama_lengkap }}!</h2>
                            <p class="text-emerald-100 text-xs sm:text-sm max-w-xl leading-relaxed">Pantau estimasi proyeksi KGB, status verifikasi berkas, serta unduh SK TTE resmi Anda di sini.</p>
                        </div>
                        <div class="bg-white/15 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white/25 text-xs font-medium font-mono flex items-center space-x-2 relative z-10 shrink-0 shadow-sm">
                            <svg class="w-4 h-4 text-emerald-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-6 0h6" />
                            </svg>
                            <span>NIP: {{ $pegawai->nip }}</span>
                        </div>
                        <!-- Efek Kilau / Refleksi Kaca Dekoratif -->
                        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute right-36 -top-12 w-40 h-40 bg-emerald-300/20 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute -left-10 -top-10 w-36 h-36 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                    </div>

                    <!-- ANALISIS DATA KEPEGAWAIAN (3 CARDS GRID) -->
                    <div>
                        <div class="flex items-center justify-between mb-3.5">
                            <h3 class="font-bold text-slate-900 text-sm sm:text-base flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <span>Ringkasan Analisis & Proyeksi KGB</span>
                            </h3>
                            <span class="text-xs text-slate-500 font-medium hidden sm:inline">Kalkulasi Otomatis</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">

                            <!-- Widget Analisis 1: Proyeksi Kenaikan Gaji -->
                            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3 relative overflow-hidden flex flex-col justify-between">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Estimasi Gaji Pokok Baru</span>
                                        <div class="w-9 h-9 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="text-xl sm:text-2xl font-extrabold text-slate-900">
                                            Rp {{ number_format($estimatedNewSalary, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            Gaji Pokok Lama: <span class="font-semibold text-slate-700">Rp {{ number_format($pegawai->gaji_pokok_lama, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                                    <div class="bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-md font-bold text-[11px]">
                                        +Rp {{ number_format($salaryIncrement, 0, ',', '.') }} / bln
                                    </div>
                                    <div class="text-slate-400 text-[10px] font-medium">
                                        (+Rp {{ number_format($yearlyIncrement, 0, ',', '.') }} / thn)
                                    </div>
                                </div>
                            </div>

                            <!-- Widget Analisis 2: Hitung Mundur & Alur Progress -->
                            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3 relative overflow-hidden flex flex-col justify-between">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Jatuh Tempo KGB (TMT YAD)</span>
                                        <div class="w-9 h-9 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-xl sm:text-2xl font-extrabold text-slate-900">
                                            {{ date('d M Y', strtotime($pegawai->tmt_kgb_yad)) }}
                                        </div>
                                        <div class="text-xs text-amber-600 font-semibold mt-1">
                                            @if($daysUntilKgb > 0)
                                                <span>Sisa Waktu: ~{{ $monthsUntilKgb }} Bulan ({{ $daysUntilKgb }} Hari)</span>
                                            @elseif($daysUntilKgb == 0)
                                                <span class="text-emerald-600 font-bold">Hari ini Jatuh Tempo KGB</span>
                                            @else
                                                <span class="text-emerald-600 font-bold">Telah Memasuki Masa KGB</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-1 pt-1">
                                    <div class="flex justify-between text-[11px] font-semibold text-slate-600">
                                        <span>Progres Periode KGB</span>
                                        <span>{{ $progressPercent }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Widget Analisis 3: Masa Kerja & Karir -->
                            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3 relative overflow-hidden flex flex-col justify-between sm:col-span-2 lg:col-span-1">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Golongan & Masa Kerja</span>
                                        <div class="w-9 h-9 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-xl sm:text-2xl font-extrabold text-slate-900">
                                            Gol. {{ $pegawai->pangkat_gol }}
                                        </div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            MKG Saat Ini: <span class="font-bold text-slate-800">{{ $pegawai->mkg_tahun }} Thn {{ $pegawai->mkg_bulan }} Bln</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                                    <div class="flex items-center space-x-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span class="font-semibold text-slate-700">{{ count($signedSks) }} Dokumen SK Terbit</span>
                                    </div>
                                    <a href="{{ route('gtk.usulan') }}" class="text-emerald-600 hover:underline font-bold text-[11px]">Detail &rarr;</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- USULAN TERBARU GTK -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm sm:text-base">Status Pengajuan Usulan KGB Terbaru</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Pantau perkembangan alur verifikasi berkas usulan Anda secara real-time.</p>
                            </div>
                            @if($latestUsulan)
                                <a href="{{ route('gtk.usulan') }}" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-3 py-1.5 rounded-xl transition inline-block text-center shrink-0">
                                    Lihat Semua Usulan &rarr;
                                </a>
                            @endif
                        </div>

                        @if($latestUsulan)
                            <div class="space-y-5">
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/70 grid grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                                    <div>
                                        <div class="text-[10px] uppercase font-bold text-slate-400">Nomor Usulan</div>
                                        <div class="font-bold text-slate-900 text-xs sm:text-sm font-mono mt-0.5 truncate" title="{{ $latestUsulan->nomor_usulan }}">{{ $latestUsulan->nomor_usulan }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] uppercase font-bold text-slate-400">TMT KGB Berlaku</div>
                                        <div class="font-bold text-slate-900 text-xs sm:text-sm mt-0.5">{{ date('d F Y', strtotime($latestUsulan->tmt_berlaku)) }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] uppercase font-bold text-slate-400">Gaji Pokok Baru</div>
                                        <div class="font-bold text-emerald-700 text-xs sm:text-sm mt-0.5">Rp {{ number_format($latestUsulan->gaji_pokok_baru, 0, ',', '.') }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] uppercase font-bold text-slate-400">Status Alur</div>
                                        <div class="mt-0.5">
                                            @if($latestUsulan->status === 'verifikasi')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Verifikasi Dinas</span>
                                            @elseif($latestUsulan->status === 'tte')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Proses TTE Kadis</span>
                                            @elseif($latestUsulan->status === 'selesai')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">SK Terbit & Sah</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">Perlu Revisi</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress Bar Visual Alur (4 Tahap Grid) -->
                                <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3 pt-1">
                                    <div class="bg-emerald-50 border border-emerald-200 p-3 rounded-xl">
                                        <div class="text-[10px] font-bold text-emerald-600 uppercase">Tahap 1 (Selesai)</div>
                                        <div class="text-xs font-bold text-slate-800 mt-0.5">Input Sekolah</div>
                                    </div>

                                    <div class="p-3 rounded-xl border {{ in_array($latestUsulan->status, ['verifikasi', 'disetujui', 'tte', 'selesai']) ? 'bg-amber-50 border-amber-200' : 'bg-slate-50 border-slate-200 opacity-60' }}">
                                        <div class="text-[10px] font-bold uppercase {{ in_array($latestUsulan->status, ['verifikasi', 'disetujui', 'tte', 'selesai']) ? 'text-amber-600' : 'text-slate-400' }}">
                                            Tahap 2 (Verifikasi)
                                        </div>
                                        <div class="text-xs font-bold text-slate-800 mt-0.5">Berkas Dinas</div>
                                    </div>

                                    <div class="p-3 rounded-xl border {{ in_array($latestUsulan->status, ['disetujui', 'tte', 'selesai']) ? 'bg-indigo-50 border-indigo-200' : 'bg-slate-50 border-slate-200 opacity-60' }}">
                                        <div class="text-[10px] font-bold uppercase {{ in_array($latestUsulan->status, ['disetujui', 'tte', 'selesai']) ? 'text-indigo-600' : 'text-slate-400' }}">
                                            Tahap 3 (TTE)
                                        </div>
                                        <div class="text-xs font-bold text-slate-800 mt-0.5">Validasi Kadis</div>
                                    </div>

                                    <div class="p-3 rounded-xl border {{ $latestUsulan->status === 'selesai' ? 'bg-emerald-50 border-emerald-200' : 'bg-slate-50 border-slate-200 opacity-60' }}">
                                        <div class="text-[10px] font-bold uppercase {{ $latestUsulan->status === 'selesai' ? 'text-emerald-600' : 'text-slate-400' }}">
                                            Tahap 4 (Terbit)
                                        </div>
                                        <div class="text-xs font-bold text-slate-800 mt-0.5">SK Ready</div>
                                    </div>
                                </div>

                                @if($latestUsulan->catatan_admin)
                                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600">
                                        <strong>Catatan Dinas:</strong> {{ $latestUsulan->catatan_admin }}
                                    </div>
                                @endif

                                @if($latestUsulan->status === 'selesai' && $latestUsulan->skKgb)
                                    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex flex-col lg:flex-row items-start lg:items-center justify-between gap-3">
                                        <div class="flex items-center space-x-3 text-xs text-emerald-900">
                                            <svg class="w-6 h-6 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <div>
                                                <div class="font-bold">SK KGB Resmi Telah Diterbitkan</div>
                                                <div class="text-[11px] text-emerald-700 font-mono">Nomor SK: {{ $latestUsulan->skKgb->nomor_sk }}</div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full lg:w-auto">
                                            <a href="{{ route('usulan.show', $latestUsulan->id) }}" class="bg-white hover:bg-slate-100 text-slate-900 font-bold text-xs px-3 py-2 rounded-xl transition shadow-sm text-center">
                                                Detail Usulan & Berkas &rarr;
                                            </a>
                                            <a href="{{ route('sk.preview', $latestUsulan->skKgb->id) }}" target="_blank" class="bg-emerald-800 hover:bg-emerald-900 text-emerald-100 font-bold text-xs px-3 py-2 rounded-xl transition shadow-sm text-center">
                                                Lihat SK (PDF)
                                            </a>
                                            <a href="{{ route('sk.verify', $latestUsulan->skKgb->qr_code_token ?? $latestUsulan->skKgb->id) }}" target="_blank" class="bg-teal-700 hover:bg-teal-800 text-teal-100 font-bold text-xs px-3 py-2 rounded-xl transition shadow-sm text-center">
                                                Verifikasi TTE
                                            </a>
                                            <a href="{{ route('sk.download', $latestUsulan->skKgb->id) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3.5 py-2 rounded-xl transition shadow-sm text-center">
                                                Unduh SK
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-300 text-slate-500 text-xs space-y-2">
                                <svg class="w-8 h-8 mx-auto text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <div class="font-bold text-slate-700 text-sm">Belum Ada Usulan KGB Terdaftar</div>
                                <p class="max-w-md mx-auto">Usulan KGB akan dibuat oleh Admin Sekolah saat tanggal jatuh tempo KGB Anda sudah mendekati periode pengajuan.</p>
                            </div>
                        @endif
                    </div>

                    <!-- RIWAYAT DOKUMEN SK TERBIT -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between flex-wrap gap-2">
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm sm:text-base">Arsip SK Kenaikan Gaji Berkala Saya</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Dokumen SK KGB yang telah diterbitkan dan disahkan BSrE TTE.</p>
                            </div>
                            <span class="text-xs bg-slate-100 text-slate-700 font-bold px-3 py-1 rounded-full">
                                Total: {{ count($signedSks) }} SK
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-500 text-[11px] uppercase tracking-wider border-b border-slate-100">
                                        <th class="py-3 px-4 sm:px-6 font-semibold">TMT KGB</th>
                                        <th class="py-3 px-4 sm:px-6 font-semibold">Nomor SK</th>
                                        <th class="py-3 px-4 sm:px-6 font-semibold">Tanggal Penetapan</th>
                                        <th class="py-3 px-4 sm:px-6 font-semibold">Status Legalitas</th>
                                        <th class="py-3 px-4 sm:px-6 font-semibold text-right">Aksi Dokumen</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    @forelse($signedSks as $sk)
                                        <tr class="hover:bg-slate-50/80 transition">
                                            <td class="py-3.5 px-4 sm:px-6 font-semibold text-slate-900 whitespace-nowrap">
                                                {{ date('d F Y', strtotime($sk->usulanKgb->tmt_berlaku ?? $sk->tanggal_sk)) }}
                                            </td>
                                            <td class="py-3.5 px-4 sm:px-6 text-slate-600 text-xs font-mono font-bold whitespace-nowrap">{{ $sk->nomor_sk }}</td>
                                            <td class="py-3.5 px-4 sm:px-6 text-slate-600 text-xs whitespace-nowrap">{{ date('d F Y', strtotime($sk->tanggal_sk)) }}</td>
                                            <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                                <span class="bg-emerald-100 text-emerald-700 text-[11px] font-bold px-2.5 py-0.5 rounded-full inline-flex items-center gap-1">
                                                    <span>Sah (TTE BSrE)</span>
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-4 sm:px-6 text-right whitespace-nowrap">
                                                <div class="inline-flex items-center justify-end gap-1">
                                                    <a href="{{ route('sk.preview', $sk->id) }}" target="_blank" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold px-2.5 py-1 rounded-lg text-xs border border-emerald-200 inline-flex items-center space-x-1" title="Pratinjau SK PDF">
                                                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                        <span>Lihat SK</span>
                                                    </a>
                                                    <a href="{{ route('sk.verify', $sk->qr_code_token ?? $sk->id) }}" target="_blank" class="bg-teal-50 hover:bg-teal-100 text-teal-800 font-bold px-2.5 py-1 rounded-lg text-xs border border-teal-200 inline-flex items-center space-x-1" title="Validasi TTE Resmi">
                                                        <svg class="w-3.5 h-3.5 text-teal-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                        </svg>
                                                        <span>TTE</span>
                                                    </a>
                                                    <a href="{{ route('sk.download', $sk->id) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-1 rounded-lg text-xs transition shadow-sm inline-flex items-center space-x-1" title="Unduh SK PDF">
                                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                        <span>Unduh SK</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-slate-400 text-xs italic">
                                                Belum ada SK KGB terbit untuk akun Anda.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

</body>
</html>
