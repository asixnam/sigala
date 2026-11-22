<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Usulan KGB - {{ $usulan->nomor_usulan }} - SIGALA Blora</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logoblora.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen">

    <!-- Top Navigation Bar -->
    <header class="bg-slate-900 text-white border-b border-slate-800 sticky top-0 z-30 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 min-h-[64px] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center space-x-3">
                <a href="{{ url()->previous() !== request()->url() ? url()->previous() : route('admin.usulan') }}" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition shrink-0" title="Kembali">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div class="truncate">
                    <h1 class="text-sm sm:text-base font-bold text-white flex flex-wrap items-center gap-2">
                        <span>Detail Usulan KGB</span>
                        <span class="font-mono text-xs text-emerald-400 bg-emerald-950/80 px-2.5 py-0.5 rounded-lg border border-emerald-500/30 truncate max-w-[200px] sm:max-w-none">{{ $usulan->nomor_usulan }}</span>
                    </h1>
                    <p class="text-[11px] text-slate-400 truncate mt-0.5">Pegawai: <strong class="text-slate-200">{{ $usulan->pegawai->nama_lengkap ?? $usulan->nip }}</strong> (NIP. {{ $usulan->nip }})</p>
                </div>
            </div>

            <div class="flex items-center justify-between sm:justify-end space-x-2 shrink-0 border-t sm:border-t-0 pt-2 sm:pt-0 border-slate-800/80">
                @if($usulan->status === 'selesai' && $usulan->skKgb)
                    <a href="{{ route('sk.verify', $usulan->skKgb->qr_code_token ?? $usulan->skKgb->id) }}" target="_blank" class="bg-slate-800 hover:bg-slate-700 text-emerald-400 border border-emerald-500/30 text-xs font-bold px-3 py-2 rounded-xl transition shadow flex items-center space-x-1.5" title="Verifikasi Sertifikat TTE Resmi">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Cek Validitas TTE</span>
                    </a>
                    <a href="{{ route('sk.download', $usulan->skKgb->id) }}" class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold px-3 py-2 rounded-xl transition shadow flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Unduh SK Resmi (PDF)</span>
                    </a>
                @endif
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                    {{ $usulan->status === 'selesai' ? 'bg-emerald-500 text-slate-950' : ($usulan->status === 'verifikasi' ? 'bg-amber-400 text-slate-950' : ($usulan->status === 'tte' ? 'bg-indigo-400 text-slate-950' : 'bg-slate-700 text-slate-200')) }}">
                    {{ $usulan->status }}
                </span>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto p-4 sm:p-6 space-y-6">

        @php
            $allDocuments = [];

            // 1. Add official SK KGB PDF if generated and status is selesai
            if ($usulan->status === 'selesai' && $usulan->skKgb) {
                $allDocuments[] = [
                    'id' => 'sk_kgb',
                    'nama' => 'SK KGB Resmi (Disahkan TTE)',
                    'type' => 'sk',
                    'path' => route('sk.preview', $usulan->skKgb->id),
                    'is_external' => true,
                    'is_sk' => true,
                ];
            }

            // 2. Add uploaded berkas PDFs
            if (!empty($usulan->berkas_pdf) && is_array($usulan->berkas_pdf)) {
                foreach ($usulan->berkas_pdf as $idx => $b) {
                    $bPath = is_array($b) ? ($b['path'] ?? '') : $b;
                    $bNama = is_array($b) ? ($b['nama'] ?? 'Dokumen PDF ' . ($idx + 1)) : 'Dokumen PDF ' . ($idx + 1);
                    $allDocuments[] = [
                        'id' => 'berkas_' . $idx,
                        'nama' => $bNama,
                        'type' => 'berkas',
                        'path' => asset($bPath),
                        'raw_path' => $bPath,
                        'is_external' => false,
                        'is_sk' => false,
                    ];
                }
            }
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6" x-data="{ activeDocUrl: '{{ count($allDocuments) > 0 ? $allDocuments[0]['path'] : '' }}', activeDocTitle: '{{ count($allDocuments) > 0 ? $allDocuments[0]['nama'] : '' }}' }">

            <!-- LEFT COLUMN: Metadata Usulan & Pegawai (5 Columns) -->
            <div class="lg:col-span-5 space-y-6">

                <!-- Card 1: Data Pegawai -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h2 class="font-bold text-slate-900 text-sm flex items-center space-x-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Identitas GTK / Pegawai</span>
                        </h2>
                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">
                            {{ $usulan->pegawai->pangkat_gol ?? 'PNS' }}
                        </span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</div>
                            <div class="font-bold text-slate-900 text-sm mt-0.5">{{ $usulan->pegawai->nama_lengkap ?? '-' }}</div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">NIP</div>
                                <div class="font-mono font-semibold text-slate-800 mt-0.5">{{ $usulan->nip }}</div>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pangkat / Gol.</div>
                                <div class="font-semibold text-slate-800 mt-0.5">Gol. {{ $usulan->pegawai->pangkat_gol ?? '-' }}</div>
                            </div>
                        </div>

                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Unit Kerja / Sekolah</div>
                            <div class="font-semibold text-slate-800 mt-0.5">{{ $usulan->pegawai->unit_kerja ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Detail Usulan KGB -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h2 class="font-bold text-slate-900 text-sm flex items-center space-x-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Rincian Pengajuan KGB</span>
                        </h2>
                        <span class="text-[10px] font-bold px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-md border border-emerald-200/60">
                            Periode {{ date('F Y', mktime(0,0,0, $usulan->periode_bulan, 1, $usulan->periode_tahun)) }}
                        </span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-xl grid grid-cols-2 gap-3">
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Gaji Pokok Lama</div>
                                <div class="font-bold text-slate-700 mt-0.5">Rp {{ number_format($usulan->pegawai->gaji_pokok_lama ?? 0, 0, ',', '.') }}</div>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Gaji Pokok Baru</div>
                                <div class="font-extrabold text-emerald-700 text-sm mt-0.5">Rp {{ number_format($usulan->gaji_pokok_baru, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Masa Kerja Baru (MKG)</div>
                                <div class="font-semibold text-slate-800 mt-0.5">{{ $usulan->mkg_baru_tahun }} Thn {{ $usulan->mkg_baru_bulan }} Bln</div>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TMT Berlaku KGB</div>
                                <div class="font-bold text-slate-900 mt-0.5">{{ date('d F Y', strtotime($usulan->tmt_berlaku)) }}</div>
                            </div>
                        </div>

                        @if($usulan->catatan_admin)
                            <div class="p-3.5 bg-amber-50/80 border border-amber-200 rounded-xl space-y-1 text-amber-900">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-amber-700 flex items-center space-x-1">
                                    <svg class="w-3.5 h-3.5 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span>Catatan Admin Verifikator</span>
                                </div>
                                <p class="text-xs leading-relaxed pt-0.5">{{ $usulan->catatan_admin }}</p>
                            </div>
                        @endif

                        @if($usulan->status === 'selesai' && $usulan->skKgb)
                            <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl space-y-1 text-emerald-900">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 flex items-center space-x-1">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span>Dokumen SK KGB Terbit & Sah</span>
                                </div>
                                <div class="font-mono font-bold text-xs pt-0.5">No. {{ $usulan->skKgb->nomor_sk }}</div>
                                <div class="text-[11px] text-emerald-700">Disahkan Tanggal: {{ date('d F Y', strtotime($usulan->skKgb->tanggal_sk)) }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card 3: Daftar Berkas PDF Lampiran -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
                    <h3 class="font-bold text-slate-900 text-sm flex items-center justify-between border-b border-slate-100 pb-2.5">
                        <span class="flex items-center space-x-1.5">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Daftar Berkas Terlampir</span>
                        </span>
                        <span class="text-xs bg-slate-100 text-slate-600 font-bold px-2 py-0.5 rounded-full">
                            {{ count($allDocuments) }} Berkas
                        </span>
                    </h3>

                    <div class="space-y-2">
                        @forelse($allDocuments as $doc)
                            <button @click="activeDocUrl = '{{ $doc['path'] }}'; activeDocTitle = '{{ $doc['nama'] }}'" 
                                :class="activeDocUrl === '{{ $doc['path'] }}' ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border-slate-200'"
                                class="w-full text-left p-3 rounded-xl border text-xs font-semibold transition flex items-center justify-between gap-2">
                                <div class="flex items-center space-x-2 truncate">
                                    @if(isset($doc['is_sk']) && $doc['is_sk'])
                                        <svg class="w-4 h-4 shrink-0 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 1H7a2 2 0 00-2 2v16a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                    <span class="truncate">{{ $doc['nama'] }}</span>
                                </div>
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        @empty
                            <div class="p-4 text-center bg-slate-50 rounded-xl text-xs text-slate-400 italic">
                                Belum ada berkas PDF terlampir.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: In-Browser PDF Reader (7 Columns) -->
            <div class="lg:col-span-7 space-y-4">
                
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col h-[520px] sm:h-[650px] lg:h-[750px]">
                    
                    <!-- Viewer Toolbar Header -->
                    <div class="bg-slate-900 text-white p-3.5 px-4 sm:px-5 flex items-center justify-between border-b border-slate-800 gap-2">
                        <div class="flex items-center space-x-2.5 truncate">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
                            <span class="text-xs font-bold text-white truncate" x-text="activeDocTitle || 'Pratinjau Dokumen'">Pratinjau Dokumen</span>
                        </div>
                        <div class="flex items-center space-x-2 shrink-0">
                            <template x-if="activeDocUrl">
                                <a :href="activeDocUrl" target="_blank" class="bg-slate-800 hover:bg-slate-700 text-slate-300 text-[11px] font-semibold px-2.5 py-1.5 rounded-lg transition inline-flex items-center space-x-1" title="Buka di Tab Baru">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    <span class="hidden sm:inline">Tab Baru</span>
                                </a>
                            </template>
                            <template x-if="activeDocUrl">
                                <a :href="activeDocUrl" download class="bg-emerald-600 hover:bg-emerald-500 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg transition inline-flex items-center space-x-1 shadow-sm" title="Unduh Berkas Ini">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span>Unduh File</span>
                                </a>
                            </template>
                        </div>
                    </div>

                    <!-- Embedded PDF Iframe Viewer Body -->
                    <div class="flex-1 bg-slate-200 relative overflow-hidden">
                        <template x-if="activeDocUrl">
                            <iframe :src="activeDocUrl" class="w-full h-full border-0" title="PDF Viewer"></iframe>
                        </template>

                        <template x-if="!activeDocUrl">
                            <div class="flex flex-col items-center justify-center h-full text-slate-400 space-y-2 p-6 text-center">
                                <svg class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div class="text-sm font-bold text-slate-600">Tidak ada dokumen PDF untuk ditampilkan</div>
                                <p class="text-xs text-slate-500 max-w-sm">Pilih berkas dari panel daftar berkas di sebelah kiri untuk membacanya langsung di sini.</p>
                            </div>
                        </template>
                    </div>

                </div>

            </div>

        </div>

    </main>

</body>
</html>
