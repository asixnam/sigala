@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-2.5">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-xs sm:text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-xs font-bold">✕</button>
        </div>
    @endif

    <!-- Welcome Banner -->
    <div class="relative overflow-hidden bg-emerald-600/85 backdrop-blur-xl border border-white/25 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-emerald-900/10">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center space-x-2 mb-1.5">
                    <span class="px-2.5 py-0.5 bg-white/20 backdrop-blur-md border border-white/30 rounded-full text-[10px] font-bold uppercase tracking-wider text-emerald-50">
                        Dashboard Administrator
                    </span>
                </div>
                <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight drop-shadow-sm">Selamat Datang, {{ auth()->user()->username ?? 'Admin Dinas' }}!</h2>
                <p class="text-emerald-100 text-xs sm:text-sm mt-1 max-w-xl leading-relaxed">Rekapitulasi data usulan Kenaikan Gaji Berkala (KGB) Guru dan Tenaga Kependidikan Kabupaten Blora.</p>
            </div>
            <div class="bg-white/15 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white/25 text-xs font-medium flex items-center space-x-2 shrink-0 shadow-sm">
                <svg class="w-4 h-4 text-emerald-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Periode: {{ date('F Y') }}</span>
            </div>
        </div>
        <!-- Efek Kilau / Refleksi Kaca Dekoratif -->
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-36 -top-12 w-40 h-40 bg-emerald-300/20 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -left-10 -top-10 w-36 h-36 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
    </div>

    <!-- Statistics Cards Grid (2 Columns on Mobile, 4 Columns on Desktop) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
        
        <!-- Card 1: Total Usulan -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider truncate">Total Usulan</span>
                <div class="w-9 h-9 sm:w-11 sm:h-11 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $totalUsulan ?? 0 }}</div>
            <p class="text-[11px] text-emerald-600 font-medium mt-1 truncate">Total terdaftar di sistem</p>
        </div>

        <!-- Card 2: Menunggu Verifikasi -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider truncate">Verifikasi Berkas</span>
                <div class="w-9 h-9 sm:w-11 sm:h-11 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $pendingVerifikasi ?? 0 }}</div>
            <p class="text-[11px] text-amber-600 font-medium mt-1 truncate">Perlu ditindaklanjuti tim</p>
        </div>

        <!-- Card 3: Proses TTE Kadinas -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider truncate">Proses TTE</span>
                <div class="w-9 h-9 sm:w-11 sm:h-11 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $prosesTte ?? 0 }}</div>
            <p class="text-[11px] text-indigo-600 font-medium mt-1 truncate">Menunggu ttd Kadis</p>
        </div>

        <!-- Card 4: SK Selesai / Terbit -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider truncate">SK Terbit</span>
                <div class="w-9 h-9 sm:w-11 sm:h-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $skTerbit ?? 0 }}</div>
            <p class="text-[11px] text-emerald-600 font-medium mt-1 truncate">Siap diunduh GTK</p>
        </div>

    </div>

    <!-- Dashboard Body: Pengajuan Terbaru & Statistik Status -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Pengajuan Terbaru (Span 2) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Pengajuan KGB Terbaru</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar usulan Kenaikan Gaji Berkala masuk yang perlu ditindaklanjuti.</p>
                    </div>
                    <a href="{{ route('admin.usulan') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 inline-flex items-center space-x-1">
                        <span>Kelola Semua Usulan</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
                
                <div class="divide-y divide-slate-100">
                    @forelse($recentUsulans as $usulan)
                        <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between hover:bg-slate-50/50 transition gap-3" x-data="{ openProcess: false }">
                            <div class="flex items-center space-x-3 sm:space-x-4">
                                <!-- Status Icon Container -->
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                                    {{ $usulan->status === 'verifikasi' ? 'bg-amber-50 text-amber-600' : ($usulan->status === 'tte' ? 'bg-indigo-50 text-indigo-600' : ($usulan->status === 'selesai' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-600')) }}">
                                    @if($usulan->status === 'verifikasi')
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif($usulan->status === 'tte')
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    @elseif($usulan->status === 'selesai')
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="font-semibold text-slate-900 text-sm truncate">{{ $usulan->pegawai->nama_lengkap ?? $usulan->pegawai->nama ?? 'Pegawai' }}</h4>
                                    <p class="text-xs text-slate-500 truncate">NIP. {{ $usulan->nip }} • {{ $usulan->pegawai->unit_kerja ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end space-x-3 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                                <div class="text-left sm:text-right">
                                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider inline-block
                                        {{ $usulan->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : ($usulan->status === 'verifikasi' ? 'bg-amber-100 text-amber-700' : ($usulan->status === 'tte' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700')) }}">
                                        {{ $usulan->status }}
                                    </span>
                                    <p class="text-[10px] text-slate-400 mt-0.5">TMT: {{ date('d M Y', strtotime($usulan->tmt_berlaku)) }}</p>
                                </div>

                                <button @click="openProcess = true" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-3 py-1.5 rounded-xl text-xs transition shadow-sm inline-flex items-center space-x-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Proses</span>
                                </button>

                                <!-- Modal Proses Status Usulan -->
                                <div x-show="openProcess" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4" style="display: none;">
                                    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 text-left space-y-4">
                                        <div class="flex justify-between items-center border-b pb-3">
                                            <h3 class="font-bold text-slate-900 text-base">Proses Usulan KGB</h3>
                                            <button @click="openProcess = false" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500">Pegawai: <strong class="text-slate-800">{{ $usulan->pegawai->nama_lengkap ?? $usulan->nip }}</strong></p>
                                            <p class="text-xs text-slate-500">Nomor Usulan: <span class="font-mono text-slate-700">{{ $usulan->nomor_usulan }}</span></p>
                                        </div>

                                        <!-- Update Status Form -->
                                        <form action="{{ route('admin.usulan.updateStatus', $usulan->id) }}" method="POST" class="space-y-3">
                                            @csrf
                                            @method('PUT')
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Ubah Status Usulan</label>
                                                <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                                                    <option value="verifikasi" {{ $usulan->status === 'verifikasi' ? 'selected' : '' }}>Verifikasi Berkas</option>
                                                    <option value="disetujui" {{ $usulan->status === 'disetujui' ? 'selected' : '' }}>Disetujui Tim</option>
                                                    <option value="tte" {{ $usulan->status === 'tte' ? 'selected' : '' }}>Proses TTE Kadis</option>
                                                    <option value="selesai" {{ $usulan->status === 'selesai' ? 'selected' : '' }}>Selesai / Terbit SK</option>
                                                    <option value="ditolak" {{ $usulan->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Admin Verifikator</label>
                                                <textarea name="catatan_admin" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500" placeholder="Catatan kelengkapan dokumen...">{{ $usulan->catatan_admin }}</textarea>
                                            </div>
                                            <div class="pt-1">
                                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-xl text-xs transition">
                                                    Simpan Perubahan Status
                                                </button>
                                            </div>
                                        </form>

                                        <!-- Issue SK TTE Button if not in selesai stage -->
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
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-xs text-slate-400 italic">
                            Belum ada usulan KGB yang diajukan.
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/60 flex items-center justify-between text-xs text-slate-500">
                <span>Menampilkan {{ count($recentUsulans) }} usulan terbaru</span>
                <span class="font-medium text-emerald-600 flex items-center space-x-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Database Live</span>
                </span>
            </div>
        </div>

        <!-- Right: Statistik Status (Span 1) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-6 flex flex-col justify-between">
            <div class="space-y-6">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Statistik Process Rate</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Persentase usulan terproses sistem.</p>
                </div>

                @php
                    $tot = max($totalUsulan, 1);
                    $pctSelesai = round(($skTerbit / $tot) * 100, 1);
                    $pctPending = round(($pendingVerifikasi / $tot) * 100, 1);
                    $pctTte = round(($prosesTte / $tot) * 100, 1);
                @endphp

                <!-- Progress Bars -->
                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-700">
                            <span>SK Selesai / Terbit</span>
                            <span class="text-emerald-700 font-bold">{{ $pctSelesai }}% ({{ $skTerbit }}/{{ $tot }})</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $pctSelesai }}%"></div>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-700">
                            <span>Menunggu Verifikasi</span>
                            <span class="text-amber-700 font-bold">{{ $pctPending }}% ({{ $pendingVerifikasi }}/{{ $tot }})</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full transition-all duration-500" style="width: {{ $pctPending }}%"></div>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-700">
                            <span>Proses TTE Kadinas</span>
                            <span class="text-indigo-700 font-bold">{{ $pctTte }}% ({{ $prosesTte }}/{{ $tot }})</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full transition-all duration-500" style="width: {{ $pctTte }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- 2-Column Stat Box (Mobile & Desktop 2 Grid) -->
                <div class="grid grid-cols-2 gap-3 text-center">
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Akurasi Validasi</div>
                        <div class="text-lg font-extrabold text-slate-900 mt-1">100%</div>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Durasi Rata-rata</div>
                        <div class="text-lg font-extrabold text-slate-900 mt-1">1 Hari</div>
                    </div>
                </div>
            </div>

            <div class="bg-emerald-50/60 p-4 rounded-2xl border border-emerald-200/60 flex items-start space-x-3 text-emerald-900">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-[11px] leading-relaxed font-medium">
                    Setiap SK terbit disahkan dengan sertifikat digital BSrE dan berlaku legal secara hukum nasional.
                </p>
            </div>
        </div>

    </div>

</div>
@endsection
