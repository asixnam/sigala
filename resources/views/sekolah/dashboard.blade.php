<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin Sekolah - SIGALA Dinas Pendidikan Kab. Blora</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logoblora.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false, openUsulanModal: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- 1. SIDEBAR NAVIGATION -->
        @include('layouts.sekolah-navigation')

        <!-- 2. MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Header -->
            <x-top-header 
                title="Dashboard Satuan Pendidikan" 
                titleMobile="Dashboard Sekolah" 
                :badge="$unitKerja" 
            />

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-4 sm:p-6">
                <div class="max-w-7xl mx-auto space-y-6">

                    @if(session('success'))
                        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm flex items-center justify-between shadow-sm">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium text-xs sm:text-sm">{{ session('success') }}</span>
                            </div>
                            <button onclick="this.parentElement.remove()" class="p-1 text-emerald-500 hover:text-emerald-700 hover:bg-emerald-100/50 rounded-lg transition" title="Tutup">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    <!-- Welcome Banner -->
                    <div class="relative overflow-hidden bg-emerald-600/85 backdrop-blur-xl border border-white/25 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-emerald-900/10">
                        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <div class="flex items-center space-x-2 mb-1.5">
                                    <span class="px-2.5 py-0.5 bg-white/20 backdrop-blur-md border border-white/30 rounded-full text-[10px] font-bold uppercase tracking-wider text-emerald-50">
                                        Satuan Pendidikan
                                    </span>
                                </div>
                                <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight drop-shadow-sm">Selamat Datang, Operator {{ $unitKerja }}!</h2>
                                <p class="text-emerald-100 text-xs sm:text-sm mt-1 max-w-xl leading-relaxed">Pantau jadwal jatuh tempo Kenaikan Gaji Berkala (KGB) guru dan tenaga kependidikan di sekolah Anda.</p>
                            </div>
                            <div class="bg-white/15 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white/25 text-xs font-medium flex items-center space-x-2 shrink-0 shadow-sm">
                                <svg class="w-4 h-4 text-emerald-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H7" />
                                </svg>
                                <span>{{ $unitKerja }}</span>
                            </div>
                        </div>
                        <!-- Efek Kilau / Refleksi Kaca Dekoratif -->
                        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute right-36 -top-12 w-40 h-40 bg-emerald-300/20 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute -left-10 -top-10 w-36 h-36 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                    </div>

                    <!-- Statistics Cards Grid (2 Columns on Mobile) -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
                        
                        <!-- Card 1 -->
                        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition group">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider truncate">Total GTK</span>
                                <div class="w-9 h-9 sm:w-10 sm:h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $totalGtk }}</div>
                            <p class="text-[11px] text-slate-500 mt-1 truncate">Guru & Tenaga Kependidikan</p>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition group">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider truncate">Jatuh Tempo</span>
                                <div class="w-9 h-9 sm:w-10 sm:h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $upcomingKgb }}</div>
                            <p class="text-[11px] text-amber-600 font-medium mt-1 truncate">Periode 2 bulan kedepan</p>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition group">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider truncate">Diproses Dinas</span>
                                <div class="w-9 h-9 sm:w-10 sm:h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $diprosesDinas }}</div>
                            <p class="text-[11px] text-indigo-600 font-medium mt-1 truncate">Menunggu verifikasi/TTE</p>
                        </div>

                        <!-- Card 4 -->
                        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition group">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider truncate">SK Selesai</span>
                                <div class="w-9 h-9 sm:w-10 sm:h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $skSelesai }}</div>
                            <p class="text-[11px] text-emerald-600 font-medium mt-1 truncate">Siap diunduh GTK</p>
                        </div>

                    </div>

                    <!-- Notification Alert: Jatuh Tempo Mendatang -->
                    @if($upcomingKgb > 0)
                        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 sm:p-5 flex items-start space-x-3 text-amber-900">
                            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-xs sm:text-sm leading-relaxed">
                                <span class="font-bold">Perhatian:</span> Terdapat <span class="font-semibold underline">{{ $upcomingKgb }} GTK</span> di sekolah Anda yang memasuki masa jatuh tempo KGB dalam 2 bulan ke depan. Silakan segera lengkapi berkas persyaratan dan ajukan melalui tombol <span class="font-semibold">"Buat Usulan Baru"</span>.
                            </div>
                        </div>
                    @endif

                    <!-- Recent Table Section: Daftar GTK & Status Usulan Sekolah -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <h3 class="font-bold text-slate-900 text-base">Daftar Usulan & Status KGB GTK</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Daftar pengajuan Kenaikan Gaji Berkala dari {{ $unitKerja }}.</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button @click="openUsulanModal = true" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-sm flex items-center space-x-2 group">
                                    <svg class="w-4 h-4 text-white group-hover:rotate-90 transition-transform duration-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Buat Usulan Baru</span>
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-sm">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-100">
                                        <th class="py-3 px-6 font-semibold">Nama GTK / NIP</th>
                                        <th class="py-3 px-6 font-semibold">Gaji Baru / MKG</th>
                                        <th class="py-3 px-6 font-semibold">Jatuh Tempo (TMT)</th>
                                        <th class="py-3 px-6 font-semibold">Status Pengajuan</th>
                                        <th class="py-3 px-6 font-semibold text-center">Catatan / SK</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    @forelse($usulans as $u)
                                        <tr class="hover:bg-slate-50/80 transition">
                                            <td class="py-4 px-6">
                                                <div class="font-semibold text-slate-900">{{ $u->pegawai->nama_lengkap ?? $u->nip }}</div>
                                                <div class="text-xs text-slate-500 font-mono">NIP. {{ $u->nip }}</div>
                                            </td>
                                            <td class="py-4 px-6 text-slate-600 text-xs">
                                                <div class="font-semibold text-slate-800">Rp {{ number_format($u->gaji_pokok_baru, 0, ',', '.') }}</div>
                                                <div class="text-[11px] text-slate-500">MKG: {{ $u->mkg_baru_tahun }} Thn {{ $u->mkg_baru_bulan }} Bln</div>
                                            </td>
                                            <td class="py-4 px-6 text-slate-600 text-xs">{{ date('d F Y', strtotime($u->tmt_berlaku)) }}</td>
                                            <td class="py-4 px-6">
                                                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full uppercase
                                                    {{ $u->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : ($u->status === 'verifikasi' ? 'bg-amber-100 text-amber-700' : ($u->status === 'tte' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700')) }}">
                                                    {{ $u->status }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-6 text-center text-xs space-x-1 whitespace-nowrap">
                                                <a href="{{ route('usulan.show', $u->id) }}" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold px-2.5 py-1 rounded-lg text-xs border border-indigo-200/80 inline-flex items-center space-x-1 shadow-sm transition" title="Lihat Detail & Baca Berkas PDF">
                                                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    <span>Detail & Berkas</span>
                                                </a>
                                                @if($u->status === 'selesai' && $u->skKgb)
                                                    <a href="{{ route('sk.preview', $u->skKgb->id) }}" target="_blank" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold px-2.5 py-1 rounded-lg border border-emerald-200 inline-flex items-center space-x-1" title="Pratinjau SK KGB PDF">
                                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                        <span>Lihat SK</span>
                                                    </a>
                                                    <a href="{{ route('sk.verify', $u->skKgb->qr_code_token ?? $u->skKgb->id) }}" target="_blank" class="bg-teal-50 hover:bg-teal-100 text-teal-800 font-semibold px-2 py-1 rounded-lg border border-teal-200 inline-flex items-center space-x-1" title="Validasi Sertifikat TTE (Scan QR)">
                                                        <svg class="w-3.5 h-3.5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                        </svg>
                                                        <span>TTE</span>
                                                    </a>
                                                    <a href="{{ route('sk.download', $u->skKgb->id) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-2.5 py-1 rounded-lg transition shadow-sm inline-flex items-center space-x-1" title="Unduh SK KGB PDF">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                        <span>Unduh SK</span>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-12 text-center text-slate-400 text-xs">
                                                <div class="flex flex-col items-center justify-center space-y-2">
                                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                        </svg>
                                                    </div>
                                                    <p class="font-medium text-slate-500">Belum ada usulan KGB yang diajukan dari sekolah Anda.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="p-4 border-t border-slate-100">
                            {{ $usulans->links() }}
                        </div>

                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Modal Buat Usulan Baru -->
    <div x-show="openUsulanModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left" style="display: none;">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-bold text-slate-900 text-base">Buat Usulan KGB Baru</h3>
                <button @click="openUsulanModal = false" class="p-1 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition" title="Tutup">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('sekolah.usulan.store') }}" method="POST" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Guru / GTK</label>
                    <select name="nip" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach($schoolPegawais as $p)
                            <option value="{{ $p->nip }}">{{ $p->nama_lengkap }} (NIP. {{ $p->nip }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Periode Bulan</label>
                        <select name="periode_bulan" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                            @for($m=1; $m<=12; $m++)
                                <option value="{{ $m }}" {{ $m == date('n') ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Periode Tahun</label>
                        <input type="number" name="periode_tahun" value="{{ date('Y') }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Gaji Pokok Baru (Rp)</label>
                        <input type="number" name="gaji_pokok_baru" value="4450000" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">TMT Berlaku KGB Baru</label>
                        <input type="date" name="tmt_berlaku" value="{{ date('Y-m-01') }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Masa Kerja Baru (Tahun / Bulan)</label>
                    <div class="flex space-x-2">
                        <input type="number" name="mkg_baru_tahun" value="14" placeholder="Tahun" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        <input type="number" name="mkg_baru_bulan" value="6" placeholder="Bulan" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Pengajuan (Opsional)</label>
                    <textarea name="catatan_admin" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs" placeholder="Berkas pendukung SK KGB terakhir dan SPMT sudah diverifikasi sekolah..."></textarea>
                </div>

                <div class="pt-3 flex justify-end space-x-2 border-t">
                    <button type="button" @click="openUsulanModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold">Kirim Usulan Ke Dinas</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
