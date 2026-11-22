<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Sekolah - {{ $unitKerja }}</title>
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
        @include('layouts.sekolah-navigation')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Header Bar -->
            <x-top-header title="Profil & Pengaturan Sekolah" titleMobile="Profil Sekolah">
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
                        <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs space-y-1">
                            <div class="font-semibold flex items-center space-x-1.5 text-xs">
                                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>Gagal Memperbarui Profil Sekolah:</span>
                            </div>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- MODE 1: PREVIEW PROFIL SEKOLAH (TAMPILAN MODERN) -->
                    <div x-show="activeTab === 'preview'" class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden space-y-6">
                        
                        <!-- Header Cover Banner & Logo Sekolah Avatar -->
                        <div class="relative h-36 bg-gradient-to-r from-emerald-800 via-teal-800 to-slate-900 p-6 flex items-end">
                            <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px] opacity-10"></div>
                            
                            <!-- Logo Sekolah Avatar -->
                            <div class="absolute -bottom-8 left-6 sm:left-8">
                                @if($user->logo_sekolah && file_exists(public_path($user->logo_sekolah)))
                                    <img src="{{ asset($user->logo_sekolah) }}" alt="{{ $unitKerja }}" class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-4 border-white shadow-lg bg-white">
                                @else
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-extrabold text-2xl sm:text-3xl border-4 border-white shadow-lg">
                                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H7" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="ml-24 sm:ml-32 text-white pb-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded bg-white/20 border border-white/30">
                                    Admin Sekolah
                                </span>
                            </div>
                        </div>

                        <!-- Info Header & Tombol Edit -->
                        <div class="pt-6 px-6 sm:px-8 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-5">
                            <div>
                                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">{{ $unitKerja }}</h2>
                                <p class="text-xs text-slate-500 mt-0.5">Kabupaten Blora • Dinas Pendidikan • Total {{ $totalPegawai }} GTK Terdaftar</p>
                            </div>
                            <button @click="activeTab = 'edit'" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition shadow-sm inline-flex items-center space-x-1.5 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Edit Data & Foto</span>
                            </button>
                        </div>

                        <!-- Data Identitas Sekolah Grid Cards -->
                        <div class="px-6 sm:px-8 pb-6 space-y-4">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Identitas & Akun Sekolah</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Sekolah / Unit Kerja</span>
                                    <div class="font-bold text-slate-900 text-sm">{{ $unitKerja }}</div>
                                </div>

                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Username Login Admin</span>
                                    <div class="font-mono font-bold text-slate-800 text-sm">{{ $user->username ?? '-' }}</div>
                                </div>

                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Email Official Sekolah</span>
                                    <div class="font-semibold text-slate-800 text-sm">{{ $user->email ?? '-' }}</div>
                                </div>

                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Terdaftar GTK</span>
                                    <div class="font-bold text-emerald-700 text-sm">{{ $totalPegawai }} Pegawai / Guru</div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-100 text-[11px] text-slate-400 flex items-center space-x-1.5">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Akun sekolah terintegrasi langsung dengan database layanan SIGALA Dinas Pendidikan Kabupaten Blora.</span>
                            </div>
                        </div>

                    </div>

                    <!-- MODE 2: FORM EDIT DATA & UPLOAD FOTO LOGO SEKOLAH -->
                    <div x-show="activeTab === 'edit'" class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
                        
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div>
                                <h3 class="font-bold text-slate-900 text-base sm:text-lg">Edit Data Profil & Kredensial Sekolah</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Perbarui foto logo sekolah, nama unit kerja, email, atau kata sandi akun sekolah.</p>
                            </div>
                            <button @click="activeTab = 'preview'" class="text-xs text-slate-500 hover:text-slate-700 font-semibold">
                                &larr; Batal / Kembali
                            </button>
                        </div>

                        <form action="{{ route('sekolah.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf

                            <!-- Upload Foto Logo Sekolah Section -->
                            <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl flex flex-col sm:flex-row items-center gap-4">
                                <div class="shrink-0">
                                    @if($user->logo_sekolah && file_exists(public_path($user->logo_sekolah)))
                                        <img src="{{ asset($user->logo_sekolah) }}" alt="Logo" class="w-16 h-16 rounded-2xl object-cover border border-slate-200 shadow-sm">
                                    @else
                                        <div class="w-16 h-16 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xl border border-slate-200 shadow-sm">
                                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H7" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 space-y-1 text-center sm:text-left">
                                    <label class="block text-xs font-bold text-slate-700">Upload / Ganti Foto Logo Sekolah</label>
                                    <input type="file" name="logo_sekolah" accept="image/*" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-xs bg-white">
                                    <p class="text-[10px] text-slate-400">Pilih berkas gambar logo (JPG, PNG, WEBP, SVG) maksimal 5 MB.</p>
                                </div>
                            </div>

                            <!-- Input Form Fields Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                
                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Nama Sekolah / Unit Kerja</label>
                                    <input type="text" name="unit_kerja" value="{{ old('unit_kerja', $user->unit_kerja) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-medium">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Username Login Admin</label>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-medium">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Email Official Sekolah</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-medium">
                                </div>

                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Kata Sandi Baru (Kosongkan jika tidak diubah)</label>
                                    <input type="password" name="password" placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-medium">
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
                                    <span>Simpan Perubahan Profil</span>
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
