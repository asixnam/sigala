@props([
    'usulans',
    'pegawais' => [],
    'pegawai' => null,
    'latestUsulan' => null,
    'filterRoute' => request()->url(),
    'isSekolahRole' => false,
    'isGtkRole' => false
])

<div class="max-w-7xl mx-auto space-y-5" x-data="{ openCreateUsulanModal: false }">

    @if(session('success'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs sm:text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-xs font-bold p-1">✕</button>
        </div>
    @endif

    @if($errors->any())
        <div class="p-3.5 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-xs space-y-1">
            <div class="font-semibold flex items-center space-x-1 text-xs">
                <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Gagal Memproses Usulan:</span>
            </div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Latest Usulan Tracker Banner for GTK Role -->
    @if($isGtkRole && $latestUsulan)
        <div class="relative overflow-hidden bg-emerald-600/85 backdrop-blur-xl border border-white/25 rounded-3xl p-5 sm:p-8 text-white shadow-xl shadow-emerald-900/10 space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-white/15 pb-4 relative z-10">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-emerald-50">
                        Usulan KGB Terbaru
                    </span>
                    <h2 class="text-xl sm:text-2xl font-extrabold mt-1.5 font-mono drop-shadow-sm">{{ $latestUsulan->nomor_usulan }}</h2>
                    <p class="text-xs text-emerald-100">TMT KGB: {{ date('d F Y', strtotime($latestUsulan->tmt_berlaku)) }}</p>
                </div>
                <div>
                    @if($latestUsulan->status === 'verifikasi')
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-400 text-slate-950 shadow-sm inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-950 animate-pulse"></span>
                            Sedang Diverifikasi Dinas
                        </span>
                    @elseif($latestUsulan->status === 'tte')
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-blue-400 text-slate-950 shadow-sm inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-950 animate-pulse"></span>
                            Dalam Proses TTE Kadis
                        </span>
                    @elseif($latestUsulan->status === 'selesai')
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-400 text-slate-950 shadow-sm inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-950"></span>
                            SK KGB Terbit & Sah
                        </span>
                    @else
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-rose-400 text-white shadow-sm inline-flex items-center gap-1.5">
                            Perlu Perbaikan
                        </span>
                    @endif
                </div>
            </div>

            <!-- Stepper Alur Process -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3 text-center pt-1 relative z-10">
                <div class="p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 space-y-1">
                    <div class="text-[10px] uppercase tracking-wider text-slate-200">Tahap 1</div>
                    <div class="text-xs font-bold text-yellow-300">Diajukan Sekolah</div>
                </div>
                <div class="p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 space-y-1">
                    <div class="text-[10px] uppercase tracking-wider text-slate-200">Tahap 2</div>
                    <div class="text-xs font-bold {{ in_array($latestUsulan->status, ['tte', 'selesai']) ? 'text-yellow-300' : 'text-amber-200' }}">Verifikasi Berkas</div>
                </div>
                <div class="p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 space-y-1">
                    <div class="text-[10px] uppercase tracking-wider text-slate-200">Tahap 3</div>
                    <div class="text-xs font-bold {{ $latestUsulan->status === 'selesai' ? 'text-yellow-300' : ($latestUsulan->status === 'tte' ? 'text-cyan-200' : 'text-slate-300/70') }}">Validasi TTE</div>
                </div>
                <div class="p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 space-y-1">
                    <div class="text-[10px] uppercase tracking-wider text-slate-200">Tahap 4</div>
                    <div class="text-xs font-bold {{ $latestUsulan->status === 'selesai' ? 'text-yellow-300' : 'text-slate-300/70' }}">SK Terbit</div>
                </div>
            </div>

            @if($latestUsulan->status === 'selesai' && $latestUsulan->skKgb)
                <div class="pt-2 flex flex-wrap justify-end gap-2 relative z-10">
                    <a href="{{ route('usulan.show', $latestUsulan->id) }}" class="bg-white/90 hover:bg-white text-slate-900 font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-sm inline-flex items-center gap-1.5">
                        <span>Detail Usulan & Berkas</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <a href="{{ route('sk.download', $latestUsulan->skKgb->id) }}" class="bg-yellow-400 hover:bg-yellow-300 text-slate-950 font-bold text-xs px-4 py-2.5 rounded-xl transition inline-flex items-center space-x-1.5 shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Unduh SK KGB Resmi</span>
                    </a>
                </div>
            @endif
            <!-- Efek Kilau / Refleksi Kaca Dekoratif -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute right-36 -top-12 w-40 h-40 bg-emerald-300/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -left-10 -top-10 w-36 h-36 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
        </div>
    @endif

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                {{ $isGtkRole ? 'Daftar Riwayat Usulan KGB Saya' : 'Kelola Usulan KGB & TTE SK' }}
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                @if($isGtkRole)
                    Seluruh riwayat catatan dan alur pengajuan Kenaikan Gaji Berkala atas nama Anda.
                @elseif($isSekolahRole)
                    Buat usulan baru, verifikasi berkas, dan pantau status usulan KGB GTK sekolah Anda.
                @else
                    Buat usulan baru, verifikasi berkas, edit data, dan terbitkan SK Kenaikan Gaji Berkala sah dengan TTE.
                @endif
            </p>
        </div>
        <div class="shrink-0">
            <button @click="openCreateUsulanModal = true" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-sm inline-flex items-center justify-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>{{ $isGtkRole ? 'Ajukan Usulan KGB Mandiri' : 'Buat Usulan Baru' }}</span>
            </button>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        
        <!-- Filter Form -->
        <form method="GET" action="{{ $filterRoute }}" class="p-4 border-b border-slate-100 bg-slate-50/50">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-wrap lg:items-end gap-3">
                
                <!-- Input Cari -->
                <div class="flex flex-col space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Cari Usulan</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nomor Usulan / TMT / Nama..." class="w-full sm:w-64 px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Status Dropdown -->
                <div class="flex flex-col space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</label>
                    <select name="status" class="w-full sm:w-44 px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white text-slate-700 focus:ring-2 focus:ring-emerald-500 font-medium">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="verifikasi" {{ request('status') == 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="tte" {{ request('status') == 'tte' ? 'selected' : '' }}>Proses TTE</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Tombol Filter & Reset -->
                <div class="flex items-center space-x-2 pt-1 sm:pt-0">
                    <button type="submit" class="flex-1 sm:flex-initial bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition shadow-sm inline-flex items-center justify-center space-x-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span>Filter</span>
                    </button>
                    <a href="{{ $filterRoute }}" class="text-xs text-slate-500 hover:text-red-500 font-semibold px-3 py-2 rounded-xl transition">
                        Reset
                    </a>
                </div>

            </div>
        </form>

        <!-- Tabel Usulan -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[11px] uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3 px-4 sm:px-6 font-semibold">Pegawai & Usulan</th>
                        <th class="py-3 px-4 sm:px-6 font-semibold">Gaji & MKG Baru</th>
                        <th class="py-3 px-4 sm:px-6 font-semibold">Status Pengajuan</th>
                        <th class="py-3 px-4 sm:px-6 font-semibold text-center">Aksi / Berkas SK</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($usulans as $usulan)
                        <tr class="hover:bg-slate-50/80 transition" x-data="{ openStatusModal: false, openEditUsulanModal: false }">
                            
                            <!-- Col 1: Pegawai & Usulan -->
                            <td class="py-3.5 px-4 sm:px-6">
                                <div class="font-bold text-slate-900">{{ $usulan->pegawai->nama_lengkap ?? $usulan->nip }}</div>
                                <div class="text-[11px] text-slate-500">NIP. {{ $usulan->nip }} • {{ $usulan->pegawai->unit_kerja ?? '-' }}</div>
                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">No: {{ $usulan->nomor_usulan }} | TMT: {{ date('d-m-Y', strtotime($usulan->tmt_berlaku)) }}</div>
                                
                                @if(!empty($usulan->berkas_pdf) && is_array($usulan->berkas_pdf) && count($usulan->berkas_pdf) > 0)
                                    <div class="mt-1.5 flex flex-wrap gap-1">
                                        @foreach($usulan->berkas_pdf as $bIdx => $berkas)
                                            @php
                                                $bPath = is_array($berkas) ? ($berkas['path'] ?? '') : $berkas;
                                                $bNama = is_array($berkas) ? ($berkas['nama'] ?? 'Dokumen PDF') : 'PDF ' . ($bIdx + 1);
                                            @endphp
                                            <a href="{{ asset($bPath) }}" target="_blank" class="inline-flex items-center space-x-1 text-[10px] bg-red-50 hover:bg-red-100 text-red-700 font-semibold px-2 py-0.5 rounded-lg border border-red-200/80 transition" title="Buka {{ $bNama }}">
                                                <svg class="w-3 h-3 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 1H7a2 2 0 00-2 2v16a2 2 0 002 2z" />
                                                </svg>
                                                <span class="truncate max-w-[120px] sm:max-w-[150px]">{{ $bNama }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </td>

                            <!-- Col 2: Gaji & MKG Baru -->
                            <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                <div class="font-bold text-slate-800">Rp {{ number_format($usulan->gaji_pokok_baru, 0, ',', '.') }}</div>
                                <div class="text-[11px] text-slate-500">MKG: {{ $usulan->mkg_baru_tahun }} Thn {{ $usulan->mkg_baru_bulan }} Bln</div>
                            </td>

                            <!-- Col 3: Status -->
                            <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase
                                    {{ $usulan->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : ($usulan->status === 'verifikasi' ? 'bg-amber-100 text-amber-700' : ($usulan->status === 'tte' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700')) }}">
                                    {{ $usulan->status }}
                                </span>
                            </td>

                            <!-- Col 4: Aksi -->
                            <td class="py-3.5 px-4 sm:px-6 text-center whitespace-nowrap">
                                <div class="inline-flex items-center justify-center gap-1 flex-wrap">
                                    
                                    <!-- Tombol Detail & Baca Berkas -->
                                    <a href="{{ route('usulan.show', $usulan->id) }}" title="Lihat Detail & Baca Berkas PDF" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold px-2.5 py-1 rounded-lg text-xs border border-indigo-200/80 inline-flex items-center space-x-1 shadow-sm transition">
                                        <svg class="w-3.5 h-3.5 text-indigo-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Detail</span>
                                    </a>

                                    @if($usulan->status === 'selesai' && $usulan->skKgb)
                                        <a href="{{ route('sk.preview', $usulan->skKgb->id) }}" target="_blank" title="Pratinjau SK KGB PDF" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold px-2.5 py-1 rounded-lg text-xs border border-emerald-200/80 inline-flex items-center space-x-1 transition">
                                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span>Lihat SK</span>
                                        </a>
                                        <a href="{{ route('sk.verify', $usulan->skKgb->qr_code_token ?? $usulan->skKgb->id) }}" target="_blank" title="Validasi Sertifikat TTE Resmi (Hasil Scan QR)" class="bg-teal-50 hover:bg-teal-100 text-teal-800 font-semibold px-2 py-1 rounded-lg text-xs border border-teal-200/80 inline-flex items-center space-x-1 transition">
                                            <svg class="w-3.5 h-3.5 text-teal-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            <span>TTE</span>
                                        </a>
                                        <a href="{{ route('sk.download', $usulan->skKgb->id) }}" title="Unduh SK KGB PDF" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-2.5 py-1 rounded-lg text-xs transition shadow-sm inline-flex items-center space-x-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            <span>Unduh SK</span>
                                        </a>
                                    @endif

                                    @if(!$isGtkRole)
                                        <button @click="openStatusModal = true" title="Kelola Status & TTE" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-2.5 py-1 rounded-lg text-xs border border-slate-300/60 inline-flex items-center space-x-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>Status</span>
                                        </button>

                                        <button @click="openEditUsulanModal = true" title="Edit Data Usulan" class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold px-2.5 py-1 rounded-lg text-xs border border-amber-200/60 inline-flex items-center space-x-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            <span>Edit</span>
                                        </button>

                                        <form action="{{ route('admin.usulan.destroy', $usulan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus usulan KGB {{ $usulan->nomor_usulan }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Usulan" class="bg-red-50 hover:bg-red-100 text-red-700 font-semibold px-2.5 py-1 rounded-lg text-xs border border-red-200/60 inline-flex items-center space-x-1">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <!-- Modal Kelola Status -->
                                <div x-show="openStatusModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left" style="display: none;">
                                    <div class="bg-white rounded-2xl max-w-md w-full p-5 sm:p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[85vh] overflow-y-auto">
                                        <div class="flex justify-between items-center border-b pb-3">
                                            <h3 class="font-bold text-slate-900 text-base">Kelola Status Usulan KGB</h3>
                                            <button @click="openStatusModal = false" class="text-slate-400 hover:text-slate-600 font-bold p-1">✕</button>
                                        </div>

                                        <div>
                                            <p class="text-xs text-slate-500">GTK: <strong class="text-slate-800">{{ $usulan->pegawai->nama_lengkap ?? $usulan->nip }}</strong></p>
                                            <p class="text-xs text-slate-500">Nomor Usulan: <span class="font-mono text-slate-700">{{ $usulan->nomor_usulan }}</span></p>
                                        </div>

                                        @if(!empty($usulan->berkas_pdf) && is_array($usulan->berkas_pdf))
                                            <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5 text-xs">
                                                <span class="font-bold text-slate-700 text-[11px] flex items-center space-x-1">
                                                    <svg class="w-3.5 h-3.5 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 1H7a2 2 0 00-2 2v16a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>Berkas PDF Terlampir ({{ count($usulan->berkas_pdf) }}):</span>
                                                </span>
                                                <div class="flex flex-col space-y-1">
                                                    @foreach($usulan->berkas_pdf as $bIdx => $berkas)
                                                        @php
                                                            $bPath = is_array($berkas) ? ($berkas['path'] ?? '') : $berkas;
                                                            $bNama = is_array($berkas) ? ($berkas['nama'] ?? 'Dokumen PDF') : 'PDF ' . ($bIdx + 1);
                                                        @endphp
                                                        <a href="{{ asset($bPath) }}" target="_blank" class="text-emerald-700 hover:underline font-semibold text-[11px] flex items-center space-x-1">
                                                            <svg class="w-3.5 h-3.5 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 1H7a2 2 0 00-2 2v16a2 2 0 002 2z" />
                                                            </svg>
                                                            <span>{{ $bNama }}</span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        @if($isSekolahRole && in_array($usulan->status, ['disetujui', 'tte', 'selesai', 'ditolak']))
                                            <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-900 font-medium space-y-1">
                                                <div class="font-bold text-amber-950 flex items-center space-x-1">
                                                    <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                    <span>Status Terkunci</span>
                                                </div>
                                                <p>Status usulan saat ini: <strong class="uppercase font-bold text-amber-950">{{ $usulan->status }}</strong>.</p>
                                                <p class="text-[11px] text-amber-800">Usulan ini sedang/telah diproses langsung oleh Dinas Pendidikan Kabupaten Blora.</p>
                                            </div>
                                        @else
                                            <form action="{{ route('admin.usulan.updateStatus', $usulan->id) }}" method="POST" class="space-y-3">
                                                @csrf
                                                @method('PUT')
                                                <div>
                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status Usulan</label>
                                                    <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                                                        <option value="draft" {{ $usulan->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                                        <option value="verifikasi" {{ $usulan->status === 'verifikasi' ? 'selected' : '' }}>Verifikasi Berkas</option>
                                                        @if(!$isSekolahRole)
                                                            <option value="disetujui" {{ $usulan->status === 'disetujui' ? 'selected' : '' }}>Disetujui Tim</option>
                                                            <option value="tte" {{ $usulan->status === 'tte' ? 'selected' : '' }}>Proses TTE Kadis</option>
                                                            <option value="selesai" {{ $usulan->status === 'selesai' ? 'selected' : '' }}>Selesai / Terbit SK</option>
                                                            <option value="ditolak" {{ $usulan->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                        @endif
                                                    </select>
                                                    @if($isSekolahRole)
                                                        <p class="text-[10px] text-slate-400 mt-1">* Admin Sekolah berhak memproses usulan hingga tahap Verifikasi Berkas.</p>
                                                    @endif
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Admin</label>
                                                    <textarea name="catatan_admin" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500" placeholder="Catatan kelengkapan dokumen berkas...">{{ $usulan->catatan_admin }}</textarea>
                                                </div>
                                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-xl text-xs transition">
                                                    Simpan Status
                                                </button>
                                            </form>
                                        @endif

                                        @if(!$isSekolahRole)
                                            @if($usulan->status !== 'selesai')
                                                <form action="{{ route('admin.usulan.generateSk', $usulan->id) }}" method="POST" class="pt-3 border-t border-slate-100">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Terbitkan SK KGB resmi dengan TTE digital untuk usulan ini?')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl text-xs transition flex items-center justify-center space-x-1.5 shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                        <span>Terbitkan & Sahkan SK TTE (BSrE)</span>
                                                    </button>
                                                </form>
                                            @else
                                                <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 font-medium flex items-center space-x-2">
                                                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>SK KGB resmi telah disahkan dengan TTE digital.</span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <!-- Modal Edit Usulan -->
                                <div x-show="openEditUsulanModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left" style="display: none;">
                                    <div class="bg-white rounded-2xl max-w-md w-full p-5 sm:p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[85vh] overflow-y-auto">
                                        <div class="flex justify-between items-center border-b pb-3">
                                            <h3 class="font-bold text-slate-900 text-base">Edit Data Usulan KGB</h3>
                                            <button @click="openEditUsulanModal = false" class="text-slate-400 hover:text-slate-600 font-bold p-1">✕</button>
                                        </div>

                                        <form action="{{ route('admin.usulan.update', $usulan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                            @csrf
                                            @method('PUT')

                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Gaji Pokok Baru (Rp)</label>
                                                <input type="number" name="gaji_pokok_baru" value="{{ $usulan->gaji_pokok_baru }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                            </div>

                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">MKG Tahun</label>
                                                    <input type="number" name="mkg_baru_tahun" value="{{ $usulan->mkg_baru_tahun }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">MKG Bulan</label>
                                                    <input type="number" name="mkg_baru_bulan" value="{{ $usulan->mkg_baru_bulan }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">TMT Berlaku Baru</label>
                                                <input type="date" name="tmt_berlaku" value="{{ $usulan->tmt_berlaku }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                            </div>

                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Status Usulan</label>
                                                <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                                    <option value="draft" {{ $usulan->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                                    <option value="verifikasi" {{ $usulan->status === 'verifikasi' ? 'selected' : '' }}>Verifikasi Berkas</option>
                                                    <option value="disetujui" {{ $usulan->status === 'disetujui' ? 'selected' : '' }}>Disetujui Tim</option>
                                                    <option value="tte" {{ $usulan->status === 'tte' ? 'selected' : '' }}>Proses TTE Kadis</option>
                                                    <option value="selesai" {{ $usulan->status === 'selesai' ? 'selected' : '' }}>Selesai / Terbit SK</option>
                                                    <option value="ditolak" {{ $usulan->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Tambah Berkas PDF Pendukung (Bisa Multi File)</label>
                                                <input type="file" name="berkas_pdf[]" accept=".pdf" multiple class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-xs bg-slate-50">
                                                <p class="text-[10px] text-slate-400 mt-0.5">Dapat memilih lebih dari 1 file PDF sekaligus.</p>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Admin</label>
                                                <textarea name="catatan_admin" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">{{ $usulan->catatan_admin }}</textarea>
                                            </div>

                                            <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">
                                                <button type="button" @click="openEditUsulanModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold">Batal</button>
                                                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 text-xs italic">
                                Belum ada data usulan KGB.
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

    <!-- Modal Buat Usulan KGB Baru -->
    <div x-show="openCreateUsulanModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left" style="display: none;">
        <div class="bg-white rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[85vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-bold text-slate-900 text-base">
                    {{ $isGtkRole ? 'Ajukan Usulan KGB Mandiri' : 'Buat Usulan KGB Baru' }}
                </h3>
                <button @click="openCreateUsulanModal = false" class="text-slate-400 hover:text-slate-600 font-bold p-1">✕</button>
            </div>

            <form action="{{ $isGtkRole ? route('gtk.usulan.store') : ($isSekolahRole ? route('sekolah.usulan.store') : route('admin.usulan.store')) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf

                @if($isGtkRole)
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Pegawai (Anda)</label>
                        <input type="text" value="{{ $pegawai->nama_lengkap ?? 'GTK' }} (NIP. {{ $pegawai->nip ?? '' }})" disabled class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-100 text-xs font-semibold text-slate-700">
                    </div>
                @else
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Pegawai / GTK</label>
                        <select name="nip" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->nip }}">{{ $p->nama_lengkap }} (NIP. {{ $p->nip }}) - {{ $p->unit_kerja }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
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

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
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
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Upload Berkas PDF Pendukung (Bisa Multi File)</label>
                    <input type="file" name="berkas_pdf[]" accept=".pdf" multiple class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-xs bg-slate-50">
                    <p class="text-[10px] text-slate-400 mt-0.5">Pilih 1 atau lebih file PDF (SK KGB terakhir, SK Pangkat, SPMT, Pas Foto, dll).</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Pengajuan (Opsional)</label>
                    <textarea name="catatan_admin" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs" placeholder="Catatan atau pengantar berkas usulan KGB..."></textarea>
                </div>

                <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">
                    <button type="button" @click="openCreateUsulanModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold">
                        {{ $isGtkRole ? 'Kirim Usulan KGB Mandiri' : 'Simpan Usulan KGB' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
