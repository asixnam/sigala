<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Pegawai - SIGALA Dinas Pendidikan Kab. Blora</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logoblora.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false, activeTab: 'preview' }">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Navigation -->
        @include('layouts.gtk-navigation')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Header Bar -->
            <x-top-header title="Profil & Data Kepegawaian GTK" titleMobile="Profil GTK">
                <button @click="activeTab = 'preview'" :class="activeTab === 'preview' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition">
                    Pratinjau
                </button>
                <button @click="activeTab = 'edit'" :class="activeTab === 'edit' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition flex items-center space-x-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    <span>Edit</span>
                </button>
            </x-top-header>

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-4 sm:p-6">
                <div class="max-w-4xl mx-auto space-y-5">

                    <!-- Flash Notifications -->
                    @if(session('success'))
                        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs sm:text-sm flex items-center justify-between shadow-sm">
                            <div class="flex items-center space-x-2.5">
                                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-xs font-bold p-1">✕</button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="p-3.5 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-xs space-y-1">
                            <div class="font-semibold flex items-center space-x-1.5 text-xs">
                                <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>Gagal Memperbarui Profil:</span>
                            </div>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- MODE 1: PREVIEW PROFIL (TAMPILAN MODERN) -->
                    <div x-show="activeTab === 'preview'" class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden space-y-6">
                        
                        <!-- Header Cover Banner & Foto Profil Avatar -->
                        <div class="relative h-36 bg-gradient-to-r from-emerald-800 via-teal-800 to-slate-900 p-6 flex items-end">
                            <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px] opacity-10"></div>
                            
                            <!-- Foto Profil Avatar -->
                            <div class="absolute -bottom-8 left-6 sm:left-8">
                                @if($pegawai->foto_profil && file_exists(public_path($pegawai->foto_profil)))
                                    <img src="{{ asset($pegawai->foto_profil) }}" alt="{{ $pegawai->nama_lengkap }}" class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-4 border-white shadow-lg bg-white">
                                @else
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-extrabold text-2xl sm:text-3xl border-4 border-white shadow-lg">
                                        {{ strtoupper(substr($pegawai->nama ?? 'GTK', 0, 2)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="ml-24 sm:ml-32 text-white pb-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded bg-white/20 border border-white/30">
                                    {{ $pegawai->pangkat_gol ?? 'Golongan PNS' }}
                                </span>
                            </div>
                        </div>

                        <!-- Info Header & Tombol Edit -->
                        <div class="pt-6 px-6 sm:px-8 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-5">
                            <div>
                                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">{{ $pegawai->nama_lengkap }}</h2>
                                <p class="text-xs text-slate-500 font-mono mt-0.5">NIP. {{ $pegawai->nip }} • {{ $pegawai->unit_kerja ?? '-' }}</p>
                            </div>
                            <button @click="activeTab = 'edit'" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition shadow-sm inline-flex items-center space-x-1.5 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Edit Data & Foto</span>
                            </button>
                        </div>

                        <!-- Data Kepegawaian Grid Cards -->
                        <div class="px-6 sm:px-8 pb-6 space-y-4">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Rincian Data Kepegawaian</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</span>
                                    <div class="font-bold text-slate-900 text-sm">{{ $pegawai->nama_lengkap }}</div>
                                </div>

                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">NIP Pegawai</span>
                                    <div class="font-mono font-bold text-slate-800 text-sm">{{ $pegawai->nip }}</div>
                                </div>

                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pangkat / Golongan</span>
                                    <div class="font-semibold text-slate-800 text-sm">Gol. {{ $pegawai->pangkat_gol ?? '-' }}</div>
                                </div>

                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Lahir</span>
                                    <div class="font-semibold text-slate-800 text-sm">{{ $pegawai->tanggal_lahir ? date('d F Y', strtotime($pegawai->tanggal_lahir)) : '-' }}</div>
                                </div>

                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Unit Kerja / Sekolah</span>
                                    <div class="font-semibold text-slate-800 text-sm">{{ $pegawai->unit_kerja ?? '-' }}</div>
                                </div>

                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Gaji Pokok Terakhir</span>
                                    <div class="font-bold text-slate-900 text-sm">Rp {{ number_format($pegawai->gaji_pokok_lama, 0, ',', '.') }}</div>
                                </div>

                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Masa Kerja (MKG Saat Ini)</span>
                                    <div class="font-semibold text-slate-800 text-sm">{{ $pegawai->mkg_tahun }} Tahun {{ $pegawai->mkg_bulan }} Bulan</div>
                                </div>

                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TMT KGB Terakhir</span>
                                    <div class="font-semibold text-slate-800 text-sm">{{ date('d F Y', strtotime($pegawai->tmt_kgb_terakhir)) }}</div>
                                </div>

                                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl space-y-1 col-span-1 sm:col-span-2">
                                    <span class="text-[10px] font-bold text-amber-700 uppercase tracking-wider">TMT KGB Jatuh Tempo (YAD)</span>
                                    <div class="font-bold text-amber-950 text-base">{{ date('d F Y', strtotime($pegawai->tmt_kgb_yad)) }}</div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-100 text-[11px] text-slate-400 flex items-center space-x-1.5">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Data kepegawaian terintegrasi dengan database terpadu SIGALA Dinas Pendidikan Kabupaten Blora.</span>
                            </div>
                        </div>

                    </div>

                    <!-- MODE 2: FORM EDIT DATA & UPLOAD FOTO PROFIL -->
                    <div x-show="activeTab === 'edit'" class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
                        
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div>
                                <h3 class="font-bold text-slate-900 text-base sm:text-lg">Edit Data Kepegawaian & Foto Profil</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Perbarui foto profil dan data kepegawaian Anda dengan data terbaru.</p>
                            </div>
                            <button @click="activeTab = 'preview'" class="text-xs text-slate-500 hover:text-slate-700 font-semibold">
                                &larr; Batal / Kembali
                            </button>
                        </div>

                        <form action="{{ route('gtk.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf

                            <!-- Upload Foto Profil Section -->
                            <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl flex flex-col sm:flex-row items-center gap-4">
                                <div class="shrink-0">
                                    @if($pegawai->foto_profil && file_exists(public_path($pegawai->foto_profil)))
                                        <img src="{{ asset($pegawai->foto_profil) }}" alt="Foto" class="w-16 h-16 rounded-2xl object-cover border border-slate-200 shadow-sm">
                                    @else
                                        <div class="w-16 h-16 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xl border border-slate-200 shadow-sm">
                                            {{ strtoupper(substr($pegawai->nama ?? 'GTK', 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 space-y-1 text-center sm:text-left">
                                    <label class="block text-xs font-bold text-slate-700">Upload / Ganti Foto Profil</label>
                                    <input type="file" name="foto_profil" accept="image/*" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-xs bg-white">
                                    <p class="text-[10px] text-slate-400">Pilih berkas gambar (JPG, PNG, WEBP, SVG) maksimal 5 MB.</p>
                                </div>
                            </div>

                            <!-- Input Form Fields Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                
                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">NIP Pegawai (Tidak Dapat Diubah)</label>
                                    <input type="text" value="{{ $pegawai->nip }}" disabled class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 font-mono font-semibold">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Nama Pegawai (Tanpa Gelar)</label>
                                    <input type="text" name="nama" value="{{ old('nama', $pegawai->nama) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Gelar Depan (Opsional)</label>
                                    <input type="text" name="gelar_depan" value="{{ old('gelar_depan', $pegawai->gelar_depan) }}" placeholder="Contoh: Drs., Dr., H." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Gelar Belakang (Opsional)</label>
                                    <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang', $pegawai->gelar_belakang) }}" placeholder="Contoh: M.Pd., S.Pd." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Pangkat / Golongan</label>
                                    <input type="text" name="pangkat_gol" value="{{ old('pangkat_gol', $pegawai->pangkat_gol) }}" required placeholder="Contoh: IV/a" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Unit Kerja / Sekolah</label>
                                    <input type="text" name="unit_kerja" value="{{ old('unit_kerja', $pegawai->unit_kerja) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Gaji Pokok Lama (Rp)</label>
                                    <input type="number" name="gaji_pokok_lama" value="{{ old('gaji_pokok_lama', $pegawai->gaji_pokok_lama) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Masa Kerja (MKG Tahun / Bulan)</label>
                                    <div class="flex space-x-2">
                                        <input type="number" name="mkg_tahun" value="{{ old('mkg_tahun', $pegawai->mkg_tahun) }}" required placeholder="Tahun" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                        <input type="number" name="mkg_bulan" value="{{ old('mkg_bulan', $pegawai->mkg_bulan) }}" required placeholder="Bulan" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">TMT KGB Terakhir</label>
                                    <input type="date" name="tmt_kgb_terakhir" value="{{ old('tmt_kgb_terakhir', $pegawai->tmt_kgb_terakhir) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">TMT KGB Jatuh Tempo (YAD)</label>
                                    <input type="date" name="tmt_kgb_yad" value="{{ old('tmt_kgb_yad', $pegawai->tmt_kgb_yad) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Ubah Kata Sandi Login (Kosongkan jika tidak diubah)</label>
                                    <input type="password" name="password" placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                </div>

                            </div>

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                                <button type="button" @click="activeTab = 'preview'" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                                    Batal
                                </button>
                                <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition shadow-sm inline-flex items-center space-x-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Simpan Perubahan</span>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </main>
        </div>
    </div>

</body>
</html>
