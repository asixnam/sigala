@props([
    'schools',
    'filterRoute' => request()->url()
])

<div class="max-w-7xl mx-auto space-y-6" x-data="{ openCreateSchoolModal: false, showCreatePassword: false }">

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
                <span>Gagal Memproses Data Sekolah:</span>
            </div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-slate-900">Daftar Sekolah / Unit Kerja</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola foto/logo sekolah, data unit kerja, dan akun Admin Sekolah Dinas Pendidikan Kabupaten Blora.</p>
        </div>
        <div class="shrink-0">
            <button @click="openCreateSchoolModal = true" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-sm inline-flex items-center justify-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H7" />
                </svg>
                <span>Tambah Sekolah Baru</span>
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ $filterRoute }}" class="p-3 sm:p-4 bg-white rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center space-x-2">
            <div class="relative flex-1 min-w-0">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama sekolah, email, atau username admin..." class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition shadow-sm inline-flex items-center space-x-1.5 shrink-0">
                <span>Cari</span>
            </button>

            <a href="{{ $filterRoute }}" class="text-xs text-slate-500 hover:text-red-500 font-semibold px-2.5 py-2 rounded-xl transition shrink-0">
                Reset
            </a>
        </div>
    </form>

    <!-- School Cards Grid Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
        @forelse($schools as $school)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition overflow-hidden flex flex-col justify-between" x-data="{ openEditSchoolModal: false, showEditPassword: false }">
                
                <!-- Card Header Banner & Logo -->
                <div class="relative h-32 bg-gradient-to-r from-emerald-800 via-teal-800 to-slate-900 overflow-hidden flex items-center justify-center">
                    @if($school->logo_sekolah && file_exists(public_path($school->logo_sekolah)))
                        <img src="{{ asset($school->logo_sekolah) }}" alt="{{ $school->unit_kerja }}" class="w-full h-full object-cover opacity-80 hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/30 to-transparent"></div>
                    @else
                        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px] opacity-10"></div>
                        <div class="text-center text-white/30 space-y-1">
                            <svg class="w-12 h-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H7" />
                            </svg>
                        </div>
                    @endif

                    <!-- GTK Badge Pill Top Right -->
                    <div class="absolute top-3 right-3 bg-slate-900/80 backdrop-blur-md text-emerald-400 border border-emerald-500/40 text-[10px] font-extrabold px-2.5 py-1 rounded-full shadow">
                        {{ $school->total_pegawai }} GTK Terdaftar
                    </div>

                    <!-- School Avatar Circle Overlay Left Bottom -->
                    <div class="absolute -bottom-4 left-4">
                        @if($school->logo_sekolah && file_exists(public_path($school->logo_sekolah)))
                            <img src="{{ asset($school->logo_sekolah) }}" alt="Logo" class="w-12 h-12 rounded-2xl object-cover border-2 border-white shadow-md bg-white">
                        @else
                            <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-extrabold border-2 border-white shadow-md text-base">
                                {{ strtoupper(substr($school->unit_kerja, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card Body Details -->
                <div class="p-5 pt-7 flex-1 space-y-3">

                    <div>
                        <h3 class="font-bold text-slate-900 text-base leading-snug hover:text-emerald-700 transition">
                            {{ $school->display_name ?? $school->unit_kerja ?? 'Nama Belum Diisi' }}
                        </h3>

                        <p class="text-[11px] text-slate-500 font-medium">
                            Kabupaten Blora • Dinas Pendidikan
                        </p>
                    </div>

                    <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-xl space-y-1.5 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase text-slate-400">Username Admin</span>
                            <code class="bg-white px-2 py-0.5 rounded border border-slate-200 text-slate-800 font-mono text-[11px] font-bold">{{ $school->username ?? '-' }}</code>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span class="text-[10px] font-bold uppercase text-slate-400">Email Login</span>
                            <span class="truncate max-w-[160px] font-semibold text-slate-700" title="{{ $school->email }}">{{ $school->email ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Card Footer Actions -->
                <div class="p-4 bg-slate-50/60 border-t border-slate-100 flex items-center justify-between gap-2">
                    <a href="{{ route('admin.gtk', ['unit_kerja' => $school->unit_kerja]) }}" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-xl text-xs transition shadow-sm inline-flex items-center justify-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>Kelola GTK</span>
                    </a>

                    @if($school->id)
                        <button @click="openEditSchoolModal = true" class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-xl text-xs border border-amber-200/80 transition" title="Edit Data & Gambar Sekolah">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>

                        <form action="{{ route('admin.sekolah.destroy', $school->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus akun sekolah {{ $school->unit_kerja }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-xl text-xs border border-red-200/80 transition" title="Hapus Sekolah">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>

                        <!-- Modal Edit Sekolah -->
                        <div x-show="openEditSchoolModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left" style="display: none;">
                            <div class="bg-white rounded-3xl max-w-md w-full p-5 sm:p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[85vh] overflow-y-auto">
                                <div class="flex justify-between items-center border-b pb-3">
                                    <h3 class="font-bold text-slate-900 text-base">Edit Data & Foto Sekolah</h3>
                                    <button @click="openEditSchoolModal = false" class="text-slate-400 hover:text-slate-600 font-bold p-1">✕</button>
                                </div>

                                <form action="{{ route('admin.sekolah.update', $school->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Upload / Ganti Foto Logo Sekolah</label>
                                        <input type="file" name="logo_sekolah" accept="image/*" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-xs bg-slate-50">
                                        @if($school->logo_sekolah)
                                            <p class="text-[10px] text-emerald-600 mt-1">Logo terpasang: {{ basename($school->logo_sekolah) }}</p>
                                        @endif
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Sekolah / Unit Kerja</label>
                                        <input type="text" name="unit_kerja" value="{{ $school->unit_kerja }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Admin / Username</label>
                                        <input type="text" name="username" value="{{ $school->username }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Email Sekolah (Untuk Login)</label>
                                        <input type="email" name="email" value="{{ $school->email }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Ubah Kata Sandi (Kosongkan jika tidak diubah)</label>
                                        <div class="relative">
                                            <input :type="showEditPassword ? 'text' : 'password'" name="password" placeholder="••••••••" class="w-full px-3 py-2 pr-10 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                                            <button type="button" @click="showEditPassword = !showEditPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 focus:outline-none">
                                                <template x-if="!showEditPassword">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </template>
                                                <template x-if="showEditPassword">
                                                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 013.98-.863c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18" />
                                                    </svg>
                                                </template>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">
                                        <button type="button" @click="openEditSchoolModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-slate-300 text-slate-400 text-xs italic">
                Belum ada data sekolah terdaftar.
            </div>
        @endforelse
    </div>

    <!-- Modal Tambah Sekolah Baru -->
    <div x-show="openCreateSchoolModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left" style="display: none;">
        <div class="bg-white rounded-3xl max-w-md w-full p-5 sm:p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[85vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-bold text-slate-900 text-base">Tambah Sekolah & Foto Profil Baru</h3>
                <button @click="openCreateSchoolModal = false" class="text-slate-400 hover:text-slate-600 font-bold p-1">✕</button>
            </div>

            <form action="{{ route('admin.sekolah.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Logo / Foto Profil Sekolah (Opsional)</label>
                    <input type="file" name="logo_sekolah" accept="image/*" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-xs bg-slate-50">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Sekolah / Unit Kerja</label>
                    <input type="text" name="unit_kerja" x-ref="createUnitKerjaInput" required placeholder="Contoh: SMP Negeri 3 Blora" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Admin / Username</label>
                    <input type="text" name="username" required placeholder="Contoh: admin_smp3blora" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email Sekolah (Untuk Login Admin)</label>
                    <input type="email" name="email" required placeholder="Contoh: smp3blora@sigala.test" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Admin Sekolah</label>
                    <div class="relative">
                        <input :type="showCreatePassword ? 'text' : 'password'" name="password" required value="admin123" placeholder="••••••••" class="w-full px-3 py-2 pr-10 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                        <button type="button" @click="showCreatePassword = !showCreatePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 focus:outline-none">
                            <template x-if="!showCreatePassword">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </template>
                            <template x-if="showCreatePassword">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 013.98-.863c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18" />
                                </svg>
                            </template>
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-500 mt-1">Default password: <code>admin123</code></p>
                </div>

                <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">
                    <button type="button" @click="openCreateSchoolModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold">Simpan & Buat Akun Sekolah</button>
                </div>
            </form>
        </div>
    </div>

</div>
