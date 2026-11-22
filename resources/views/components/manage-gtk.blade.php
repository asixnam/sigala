@props([
    'pegawais',
    'unitKerjaList' => [],
    'filterRoute' => request()->url(),
    'isSekolahRole' => false
])

<div class="max-w-7xl mx-auto space-y-5"
     x-data="{ openCreateModal: false }">

    {{-- =========================================================
         ALERT SUCCESS
    ========================================================== --}}
    @if(session('success'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs sm:text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-2.5">
                <svg class="w-5 h-5 text-emerald-600 shrink-0"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span class="font-medium">
                    {{ session('success') }}
                </span>
            </div>

            <button type="button"
                    onclick="this.parentElement.remove()"
                    class="text-emerald-500 hover:text-emerald-700 text-xs font-bold">
                ✕
            </button>
        </div>
    @endif


    {{-- =========================================================
         ALERT ERROR
    ========================================================== --}}
    @if($errors->any())
        <div class="p-3.5 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-xs space-y-1">

            <div class="font-semibold flex items-center space-x-1">
                <svg class="w-4 h-4 text-red-600 shrink-0"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333-.77 1.333.192 3 1.732 3z" />
                </svg>

                <span>
                    Gagal Memproses Data Pegawai:
                </span>
            </div>

            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div class="flex items-center justify-between flex-wrap gap-3 bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm">

        <div>
            <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                Data Guru & Tenaga Kependidikan (GTK) / Pegawai
            </h2>

            <p class="text-xs text-slate-500 mt-0.5">
                Kelola data kepegawaian dan pantau histori KGB GTK
                {{ $isSekolahRole ? 'di sekolah Anda' : 'Dinas Pendidikan Kabupaten Blora' }}.
            </p>
        </div>

        <div>
            <button type="button"
                    @click="openCreateModal = true"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3.5 py-2 rounded-xl transition shadow-sm inline-flex items-center space-x-1.5">

                <svg class="w-4 h-4"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 4v16m8-8H4" />
                </svg>

                <span>
                    Tambah Pegawai GTK
                </span>
            </button>
        </div>
    </div>


    {{-- =========================================================
         DATA TABLE
    ========================================================== --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

        {{-- =====================================================
             FILTER
        ====================================================== --}}
        <form method="GET"
              action="{{ $filterRoute }}"
              class="p-4 border-b border-slate-100 bg-slate-50/50">

            <div class="grid grid-cols-2 gap-2.5 sm:flex sm:flex-wrap sm:items-end">

                {{-- SEARCH --}}
                <div class="col-span-2 sm:col-span-1 flex flex-col space-y-1">

                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Cari Pegawai
                    </label>

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Nama / NIP..."
                           class="w-full sm:w-56 px-3 py-1.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>


                {{-- SORT --}}
                <div class="col-span-1 flex flex-col space-y-1">

                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Urutan
                    </label>

                    <select name="sort"
                            class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs bg-white text-slate-700 focus:ring-2 focus:ring-emerald-500 font-medium">

                        <option value="asc"
                            {{ request('sort', 'asc') === 'asc' ? 'selected' : '' }}>
                            A - Z
                        </option>

                        <option value="desc"
                            {{ request('sort') === 'desc' ? 'selected' : '' }}>
                            Z - A
                        </option>

                    </select>
                </div>


                {{-- UNIT KERJA --}}
                @if(count($unitKerjaList) > 0)

                    <div class="col-span-1 flex flex-col space-y-1">

                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            Unit Kerja
                        </label>

                        <select name="unit_kerja"
                                class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs bg-white text-slate-700 focus:ring-2 focus:ring-emerald-500 font-medium">

                            <option value="">
                                Semua Sekolah
                            </option>

                            @foreach($unitKerjaList as $unit)

                                <option value="{{ $unit }}"
                                    {{ request('unit_kerja') == $unit ? 'selected' : '' }}>
                                    {{ $unit }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                @endif


                {{-- BUTTON --}}
                <div class="col-span-2 sm:col-span-1 flex items-end space-x-1.5 pt-1 sm:pt-0">

                    <button type="submit"
                            class="flex-1 sm:flex-initial bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded-xl transition shadow-sm inline-flex items-center justify-center space-x-1">

                        <svg class="w-3.5 h-3.5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>

                        <span>
                            Filter
                        </span>
                    </button>


                    <a href="{{ $filterRoute }}"
                       class="text-xs text-slate-500 hover:text-red-500 font-semibold px-2 py-1.5 rounded-xl transition">
                        Reset
                    </a>

                </div>

            </div>
        </form>


        {{-- =====================================================
             TABLE
        ====================================================== --}}
        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse text-xs sm:text-sm">

                <thead>

                    <tr class="bg-slate-50 text-slate-500 text-[11px] uppercase tracking-wider border-b border-slate-100">

                        <th class="py-3 px-4 sm:px-6 font-semibold min-w-[240px]">
                            Nama GTK / NIP
                        </th>

                        <th class="py-3 px-4 sm:px-6 font-semibold min-w-[180px]">
                            Gol / Unit Kerja
                        </th>

                        <th class="py-3 px-4 sm:px-6 font-semibold min-w-[150px]">
                            Jatuh Tempo KGB
                        </th>

                        <th class="py-3 px-4 sm:px-6 font-semibold min-w-[130px]">
                            Status Usulan
                        </th>

                        <th class="py-3 px-4 sm:px-6 font-semibold text-center min-w-[170px]">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100 text-slate-700">

                    @forelse($pegawais as $pegawai)

                        <tr class="hover:bg-slate-50/80 transition"
                            x-data="{ openEditModal: false, openDetailModal: false }">


                            {{-- =================================================
                                 NAMA / NIP
                            ================================================== --}}
                            <td class="py-3.5 px-4 sm:px-6 min-w-[240px]">

                                {{-- NAMA --}}
                                <div class="font-bold text-slate-900 leading-5 whitespace-normal break-words">

                                    @if(!empty($pegawai->gelar_depan))
                                        {{ $pegawai->gelar_depan }}
                                    @endif

                                    {{ $pegawai->nama }}

                                    @if(!empty($pegawai->gelar_belakang))
                                        {{ ', ' . $pegawai->gelar_belakang }}
                                    @endif

                                </div>


                                {{-- NIP --}}
                                <div class="text-[11px] text-slate-500 font-mono mt-0.5 whitespace-nowrap">

                                    NIP.
                                    {{ $pegawai->nip }}

                                </div>


                                {{-- TANGGAL LAHIR --}}
                                @if($pegawai->tanggal_lahir)

                                    <div class="text-[10px] text-slate-400 mt-0.5">

                                        Lahir:
                                        {{ date('d-m-Y', strtotime($pegawai->tanggal_lahir)) }}

                                    </div>

                                @endif

                            </td>


                            {{-- =================================================
                                 GOLONGAN / UNIT KERJA
                            ================================================== --}}
                            <td class="py-3.5 px-4 sm:px-6">

                                <div class="font-semibold text-slate-800 flex items-center space-x-1.5">

                                    <span class="bg-slate-100 text-slate-800 text-[10px] px-2 py-0.5 rounded border border-slate-200 font-bold">

                                        Gol.
                                        {{ $pegawai->pangkat_gol }}

                                    </span>

                                </div>


                                <div class="text-[11px] text-slate-500 mt-1 font-medium whitespace-normal">

                                    {{ $pegawai->unit_kerja }}

                                </div>

                            </td>


                            {{-- =================================================
                                 JATUH TEMPO KGB
                            ================================================== --}}
                            <td class="py-3.5 px-4 sm:px-6 text-slate-600 text-xs">

                                @if($pegawai->tmt_kgb_yad)

                                    <div class="font-medium text-slate-800">

                                        {{ date('d-m-Y', strtotime($pegawai->tmt_kgb_yad)) }}

                                    </div>

                                @else

                                    <div class="text-slate-400">
                                        -
                                    </div>

                                @endif


                                @if($pegawai->tmt_kgb_terakhir)

                                    <div class="text-[10px] text-slate-400 mt-1">

                                        TMT Lalu:
                                        {{ date('d-m-Y', strtotime($pegawai->tmt_kgb_terakhir)) }}

                                    </div>

                                @endif

                            </td>


                            {{-- =================================================
                                 STATUS USULAN
                            ================================================== --}}
                            <td class="py-3.5 px-4 sm:px-6">

                                @php
                                    $latest = $pegawai->usulanKgbs
                                        ? $pegawai->usulanKgbs->sortByDesc('created_at')->first()
                                        : null;
                                @endphp


                                @if($latest)

                                    @php
                                        $statusClass = match($latest->status) {
                                            'selesai' => 'bg-emerald-100 text-emerald-700',
                                            'verifikasi' => 'bg-amber-100 text-amber-700',
                                            'tte' => 'bg-blue-100 text-blue-700',
                                            default => 'bg-indigo-100 text-indigo-700',
                                        };
                                    @endphp

                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase {{ $statusClass }}">

                                        {{ $latest->status }}

                                    </span>

                                @else

                                    <span class="text-[10px] text-slate-400 italic">
                                        Belum Ada
                                    </span>

                                @endif

                            </td>


                            {{-- =================================================
                                 AKSI
                            ================================================== --}}
                            <td class="py-3.5 px-4 sm:px-6 text-center whitespace-nowrap">

                                {{-- DETAIL --}}
                                <button type="button"
                                        @click="openDetailModal = true"
                                        title="Lihat Detail Lengkap Pegawai & SK"
                                        class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold px-2.5 py-1 rounded-lg text-xs border border-indigo-200/80 inline-flex items-center space-x-1 shadow-sm transition mr-1">
                                    <svg class="w-3.5 h-3.5 text-indigo-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>Detail</span>
                                </button>

                                {{-- EDIT --}}
                                <button type="button"
                                        @click="openEditModal = true"
                                        title="Edit Data GTK"
                                        class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold px-2.5 py-1 rounded-lg text-xs border border-amber-200/60 inline-flex items-center space-x-1">

                                    <svg class="w-3.5 h-3.5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>

                                    <span>
                                        Edit
                                    </span>

                                </button>


                                {{-- HAPUS --}}
                                <form action="{{ $isSekolahRole
                                    ? route('sekolah.gtk.destroy', $pegawai->nip)
                                    : route('admin.gtk.destroy', $pegawai->nip) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Hapus data pegawai {{ $pegawai->nama }}?')">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit"
                                            title="Hapus Pegawai"
                                            class="bg-red-50 hover:bg-red-100 text-red-700 font-semibold px-2.5 py-1 rounded-lg text-xs border border-red-200/60 inline-flex items-center space-x-1">

                                        <svg class="w-3.5 h-3.5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>

                                        <span>
                                            Hapus
                                        </span>

                                    </button>

                                </form>


                                {{-- =================================================
                                     MODAL DETAIL LENGKAP PEGAWAI & HISTORI SK
                                ================================================== --}}
                                <div x-show="openDetailModal"
                                     x-cloak
                                     class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-3 sm:p-6 text-left">

                                    <div @click.outside="openDetailModal = false"
                                         class="bg-white rounded-3xl max-w-4xl w-full p-6 shadow-2xl border border-slate-100 space-y-5 max-h-[92vh] overflow-y-auto">

                                        {{-- HEADER MODAL --}}
                                        <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                                            <div class="flex items-center space-x-3.5">
                                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg shadow-sm">
                                                    {{ strtoupper(substr($pegawai->nama, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="flex items-center space-x-2">
                                                        <h3 class="font-bold text-slate-900 text-lg leading-tight">
                                                            {{ $pegawai->nama_lengkap }}
                                                        </h3>
                                                        @if($pegawai->is_teknisi)
                                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                                Teknisi
                                                            </span>
                                                        @else
                                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                                Guru
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <p class="text-xs text-slate-500 font-mono mt-0.5">
                                                        NIP. {{ $pegawai->nip }} &bull; {{ $pegawai->unit_kerja }}
                                                    </p>
                                                </div>
                                            </div>
                                            <button type="button"
                                                    @click="openDetailModal = false"
                                                    class="text-slate-400 hover:text-slate-600 text-xl font-bold p-1 rounded-lg hover:bg-slate-100 transition">
                                                ✕
                                            </button>
                                        </div>

                                        {{-- GRID INFORMASI UTAMA --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            {{-- KOTAK DATA KEPEGAWAIAN --}}
                                            <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-200/60 space-y-2.5">
                                                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5 pb-1 border-b border-slate-200/80">
                                                    <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    <span>Data Profil & Kepegawaian</span>
                                                </h4>
                                                <div class="grid grid-cols-3 gap-1 text-xs">
                                                    <div class="text-slate-500">Jabatan:</div>
                                                    <div class="col-span-2 font-medium text-slate-800">{{ $pegawai->jabatan ?? ($pegawai->is_teknisi ? 'Tenaga Teknis / Teknisi' : 'Guru / Fungsional') }}</div>

                                                    <div class="text-slate-500">Golongan:</div>
                                                    <div class="col-span-2 font-semibold text-slate-800">{{ $pegawai->pangkat_gol }}</div>

                                                    <div class="text-slate-500">Tgl. Lahir:</div>
                                                    <div class="col-span-2 text-slate-800">{{ $pegawai->tanggal_lahir ? date('d-m-Y', strtotime($pegawai->tanggal_lahir)) : '-' }}</div>

                                                    <div class="text-slate-500">Unit Kerja:</div>
                                                    <div class="col-span-2 font-medium text-slate-800">{{ $pegawai->unit_kerja }}</div>

                                                    @if($pegawai->is_teknisi)
                                                        <div class="text-slate-500">Masa Kontrak:</div>
                                                        <div class="col-span-2 text-slate-800 font-medium">{{ $pegawai->masa_perjanjian_kerja ?? '-' }}</div>

                                                        <div class="text-slate-500">Perpanjangan:</div>
                                                        <div class="col-span-2 text-slate-800">{{ $pegawai->perpanjangan_perjanjian_kerja ?? '-' }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- KOTAK DATA GAJI & KGB --}}
                                            <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-200/60 space-y-2.5">
                                                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5 pb-1 border-b border-slate-200/80">
                                                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>Gaji & Periode KGB</span>
                                                </h4>
                                                <div class="grid grid-cols-3 gap-1 text-xs">
                                                    <div class="text-slate-500">Gaji Pokok:</div>
                                                    <div class="col-span-2 font-bold text-emerald-700">Rp {{ number_format($pegawai->gaji_pokok_lama, 0, ',', '.') }}</div>

                                                    <div class="text-slate-500">Masa Kerja (MKG):</div>
                                                    <div class="col-span-2 font-medium text-slate-800">{{ $pegawai->mkg_tahun }} Tahun {{ $pegawai->mkg_bulan }} Bulan</div>

                                                    <div class="text-slate-500">TMT Terakhir:</div>
                                                    <div class="col-span-2 text-slate-800">{{ $pegawai->tmt_kgb_terakhir ? date('d-m-Y', strtotime($pegawai->tmt_kgb_terakhir)) : '-' }}</div>

                                                    <div class="text-slate-500">Jatuh Tempo (YAD):</div>
                                                    <div class="col-span-2 font-bold text-indigo-700">{{ $pegawai->tmt_kgb_yad ? date('d-m-Y', strtotime($pegawai->tmt_kgb_yad)) : '-' }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- DATA SK DASAR / SK TERAKHIR --}}
                                        <div class="bg-indigo-50/50 rounded-2xl p-4 border border-indigo-100 space-y-2">
                                            <h4 class="text-xs font-bold text-indigo-900 uppercase tracking-wider flex items-center space-x-1.5">
                                                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <span>Dasar Penetapan & SK Sebelumnya</span>
                                            </h4>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 text-xs">
                                                <div>
                                                    <span class="text-slate-500 block text-[11px]">Pejabat Penerbit:</span>
                                                    <span class="font-medium text-slate-800">{{ $pegawai->sk_terakhir_pejabat ?? ($pegawai->is_teknisi ? 'Sekretaris Daerah Kab. Blora' : 'Kepala Dinas Pendidikan Kab. Blora') }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-slate-500 block text-[11px]">Nomor SK Terakhir:</span>
                                                    <span class="font-mono text-slate-800">{{ $pegawai->sk_terakhir_no ?? '-' }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-slate-500 block text-[11px]">Tanggal SK Terakhir:</span>
                                                    <span class="text-slate-800">{{ $pegawai->sk_terakhir_tgl ? date('d-m-Y', strtotime($pegawai->sk_terakhir_tgl)) : '-' }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-slate-500 block text-[11px]">Dasar Regulasi:</span>
                                                    <span class="text-slate-800">{{ $pegawai->dasar_peraturan ?? ($pegawai->is_teknisi ? 'Perpres No. 11 Th 2024' : 'PP No. 5 Th 2024') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- HISTORI USULAN & SK KGB --}}
                                        <div class="space-y-3 pt-2">
                                            <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center justify-between">
                                                <span class="flex items-center space-x-1.5">
                                                    <svg class="w-4 h-4 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                    </svg>
                                                    <span>Histori Usulan & Surat Keputusan (SK) KGB</span>
                                                </span>
                                                <span class="text-[11px] text-slate-500 font-normal">
                                                    Total {{ $pegawai->usulanKgbs->count() }} Usulan
                                                </span>
                                            </h4>

                                            @if($pegawai->usulanKgbs->count() > 0)
                                                <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                                                    <table class="w-full text-left text-xs border-collapse">
                                                        <thead class="bg-slate-100/80 text-slate-600 border-b border-slate-200">
                                                            <tr>
                                                                <th class="py-2.5 px-3 font-semibold">Nomor Usulan</th>
                                                                <th class="py-2.5 px-3 font-semibold">Periode</th>
                                                                <th class="py-2.5 px-3 font-semibold">Gaji Baru</th>
                                                                <th class="py-2.5 px-3 font-semibold">TMT Baru</th>
                                                                <th class="py-2.5 px-3 font-semibold text-center">Status</th>
                                                                <th class="py-2.5 px-3 font-semibold text-center">Dokumen SK KGB</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="divide-y divide-slate-100 bg-white">
                                                            @foreach($pegawai->usulanKgbs as $usulanItem)
                                                                <tr class="hover:bg-slate-50/80">
                                                                    <td class="py-2.5 px-3 font-mono font-medium text-slate-800">
                                                                        {{ $usulanItem->nomor_usulan }}
                                                                    </td>
                                                                    <td class="py-2.5 px-3 text-slate-600">
                                                                        {{ $usulanItem->periode_bulan }}/{{ $usulanItem->periode_tahun }}
                                                                    </td>
                                                                    <td class="py-2.5 px-3 font-bold text-emerald-700">
                                                                        Rp {{ number_format($usulanItem->gaji_pokok_baru, 0, ',', '.') }}
                                                                    </td>
                                                                    <td class="py-2.5 px-3 text-slate-700">
                                                                        {{ date('d-m-Y', strtotime($usulanItem->tmt_berlaku)) }}
                                                                    </td>
                                                                    <td class="py-2.5 px-3 text-center">
                                                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                                                            {{ $usulanItem->status === 'sk_terbit' ? 'bg-emerald-100 text-emerald-800' :
                                                                               ($usulanItem->status === 'proses_tte' ? 'bg-indigo-100 text-indigo-800' :
                                                                               ($usulanItem->status === 'ditolak' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800')) }}">
                                                                            {{ $usulanItem->status }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="py-2.5 px-3 text-center">
                                                                        @if($usulanItem->skKgb)
                                                                            <div class="inline-flex items-center space-x-1.5">
                                                                                <a href="{{ route('sk.preview', $usulanItem->skKgb->id) }}"
                                                                                   target="_blank"
                                                                                   title="Lihat / Cetak SK Format Resmi"
                                                                                   class="inline-flex items-center space-x-1 px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold text-[11px] shadow-sm transition">
                                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                                    </svg>
                                                                                    <span>Lihat SK</span>
                                                                                </a>
                                                                                <a href="{{ route('sk.download', $usulanItem->skKgb->id) }}"
                                                                                   title="Unduh SK PDF"
                                                                                   class="inline-flex items-center px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] border border-slate-300 transition">
                                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                                    </svg>
                                                                                </a>
                                                                                @if($usulanItem->skKgb->qr_code_token ?? $usulanItem->skKgb->id)
                                                                                    <a href="{{ route('tte.verify', $usulanItem->skKgb->qr_code_token ?? $usulanItem->skKgb->id) }}"
                                                                                       target="_blank"
                                                                                       title="Validasi Sertifikat TTE BSrE"
                                                                                       class="inline-flex items-center px-2 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-[10px] font-semibold border border-indigo-200 transition">
                                                                                        ✓ Valid TTE
                                                                                    </a>
                                                                                @endif
                                                                            </div>
                                                                        @else
                                                                            <span class="text-[11px] text-slate-400 italic">
                                                                                Belum terbit SK
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="bg-slate-50 border border-dashed border-slate-200 rounded-2xl p-6 text-center text-slate-500 text-xs">
                                                    Belum ada riwayat usulan KGB untuk pegawai ini.
                                                </div>
                                            @endif
                                        </div>

                                        {{-- MODAL FOOTER --}}
                                        <div class="pt-3 border-t border-slate-100 flex justify-end">
                                            <button type="button"
                                                    @click="openDetailModal = false"
                                                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
                                                Tutup
                                            </button>
                                        </div>

                                    </div>
                                </div>


                                {{-- =================================================
                                     MODAL EDIT
                                ================================================== --}}
                                <div x-show="openEditModal"
                                     x-cloak
                                     class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left">

                                    <div @click.outside="openEditModal = false"
                                         class="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[90vh] overflow-y-auto">


                                        {{-- HEADER MODAL --}}
                                        <div class="flex justify-between items-center border-b pb-3">

                                            <h3 class="font-bold text-slate-900 text-base">
                                                Edit Data Pegawai / GTK
                                            </h3>

                                            <button type="button"
                                                    @click="openEditModal = false"
                                                    class="text-slate-400 hover:text-slate-600 font-bold">

                                                ✕

                                            </button>

                                        </div>


                                        {{-- FORM EDIT --}}
                                        <form action="{{ $isSekolahRole
                                            ? route('sekolah.gtk.update', $pegawai->nip)
                                            : route('admin.gtk.update', $pegawai->nip) }}"
                                              method="POST"
                                              class="space-y-3">

                                            @csrf

                                            @method('PUT')


                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">


                                                {{-- NIP --}}
                                                <div>

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        NIP
                                                    </label>

                                                    <input type="text"
                                                           value="{{ $pegawai->nip }}"
                                                           disabled
                                                           class="w-full px-3 py-2 rounded-xl bg-slate-100 border border-slate-300 text-xs text-slate-500 font-mono">

                                                </div>


                                                {{-- NAMA --}}
                                                <div>

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        Nama Lengkap
                                                    </label>

                                                    <input type="text"
                                                           name="nama"
                                                           value="{{ $pegawai->nama }}"
                                                           required
                                                           class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">

                                                </div>


                                                {{-- TANGGAL LAHIR --}}
                                                <div>

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        Tanggal Lahir
                                                    </label>

                                                    <input type="date"
                                                           name="tanggal_lahir"
                                                           value="{{ $pegawai->tanggal_lahir }}"
                                                           class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">

                                                </div>


                                                {{-- GELAR DEPAN --}}
                                                <div>

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        Gelar Depan
                                                    </label>

                                                    <input type="text"
                                                           name="gelar_depan"
                                                           value="{{ $pegawai->gelar_depan }}"
                                                           placeholder="mis. Drs."
                                                           class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">

                                                </div>


                                                {{-- GELAR BELAKANG --}}
                                                <div>

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        Gelar Belakang
                                                    </label>

                                                    <input type="text"
                                                           name="gelar_belakang"
                                                           value="{{ $pegawai->gelar_belakang }}"
                                                           placeholder="mis. S.Pd."
                                                           class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">

                                                </div>


                                                {{-- JENIS PEGAWAI (Edit) --}}
                                                <div>

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        Jenis Pegawai
                                                    </label>

                                                    <select name="jenis_pegawai"
                                                            class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 bg-white">
                                                        <option value="guru" {{ $pegawai->is_teknisi ? '' : 'selected' }}>
                                                            Guru — Surat Kenaikan Gaji Berkala
                                                        </option>
                                                        <option value="teknisi" {{ $pegawai->is_teknisi ? 'selected' : '' }}>
                                                            Teknisi — Surat Keputusan
                                                        </option>
                                                    </select>
                                                    <p class="text-[10px] text-slate-400 mt-0.5">Menentukan format dokumen SK yang diterbitkan</p>

                                                </div>


                                                {{-- JABATAN (Edit) --}}
                                                <div>

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        Jabatan
                                                    </label>

                                                    <input type="text"
                                                           name="jabatan"
                                                           value="{{ $pegawai->jabatan }}"
                                                           placeholder="mis. Guru Ahli Madya"
                                                           class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">

                                                </div>


                                                {{-- GOLONGAN --}}
                                                <div>

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        Pangkat / Golongan
                                                    </label>

                                                    <input type="text"
                                                           name="pangkat_gol"
                                                           value="{{ $pegawai->pangkat_gol }}"
                                                           required
                                                           placeholder="mis. III/c"
                                                           class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">

                                                </div>


                                                {{-- GAJI --}}
                                                <div>

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        Gaji Pokok Lama (Rp)
                                                    </label>

                                                    <input type="number"
                                                           name="gaji_pokok_lama"
                                                           value="{{ $pegawai->gaji_pokok_lama }}"
                                                           required
                                                           min="0"
                                                           class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">

                                                </div>


                                                {{-- MASA KERJA --}}
                                                <div>

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        Masa Kerja
                                                    </label>

                                                    <div class="flex space-x-2">

                                                        <input type="number"
                                                               name="mkg_tahun"
                                                               value="{{ old('mkg_tahun', $pegawai->mkg_tahun ?? 0) }}"
                                                               placeholder="Thn"
                                                               min="0"
                                                               step="1"
                                                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">

                                                        <input type="number"
                                                               name="mkg_bulan"
                                                               value="{{ old('mkg_bulan', $pegawai->mkg_bulan ?? 0) }}"
                                                               placeholder="Bln"
                                                               min="0"
                                                               max="11"
                                                               step="1"
                                                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">

                                                    </div>

                                                </div>


                                                {{-- TMT TERAKHIR --}}
                                                <div>

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        TMT Terakhir
                                                    </label>

                                                    <input type="date"
                                                           name="tmt_kgb_terakhir"
                                                           value="{{ $pegawai->tmt_kgb_terakhir }}"
                                                           required
                                                           class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">

                                                </div>


                                                {{-- TMT YAD --}}
                                                <div>

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        TMT Jatuh Tempo (YAD)
                                                    </label>

                                                    <input type="date"
                                                           name="tmt_kgb_yad"
                                                           value="{{ $pegawai->tmt_kgb_yad }}"
                                                           required
                                                           class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">

                                                </div>


                                                {{-- UNIT KERJA --}}
                                                <div class="sm:col-span-2">

                                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                        Unit Kerja / Sekolah
                                                    </label>

                                                    <input type="text"
                                                           name="unit_kerja"
                                                           value="{{ $pegawai->unit_kerja }}"
                                                           required
                                                           class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">

                                                </div>

                                            </div>


                                            {{-- FOOTER --}}
                                            <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">

                                                <button type="button"
                                                        @click="openEditModal = false"
                                                        class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold">

                                                    Batal

                                                </button>

                                                <button type="submit"
                                                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold">

                                                    Simpan Perubahan

                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="5"
                                class="py-8 text-center text-slate-400 text-xs italic">

                                Tidak ada data pegawai yang ditemukan.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        <div class="p-4 border-t border-slate-100">

            {{ $pegawais->links() }}

        </div>

    </div>


    {{-- =========================================================
         MODAL TAMBAH PEGAWAI
    ========================================================== --}}
    <div x-show="openCreateModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left">

        <div @click.outside="openCreateModal = false"
             class="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[90vh] overflow-y-auto">


            {{-- HEADER --}}
            <div class="flex justify-between items-center border-b pb-3">

                <h3 class="font-bold text-slate-900 text-base">
                    Tambah Pegawai / GTK Baru
                </h3>

                <button type="button"
                        @click="openCreateModal = false"
                        class="text-slate-400 hover:text-slate-600 font-bold">

                    ✕

                </button>

            </div>


            {{-- FORM TAMBAH --}}
            <form action="{{ $isSekolahRole
                ? route('sekolah.gtk.store')
                : route('admin.gtk.store') }}"
                  method="POST"
                  class="space-y-3">

                @csrf


                {{-- SEKSI: IDENTITAS PEGAWAI --}}
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider pt-1 pb-0.5 border-b border-slate-100">
                    Identitas Pegawai
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    {{-- NIP --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            NIP (18 Digit) <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="nip"
                               required
                               maxlength="18"
                               placeholder="Contoh: 198505122010011001"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 font-mono">
                    </div>

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Nama Tanpa Gelar <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="nama"
                               required
                               placeholder="Contoh: Ahmad Fauzi"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>

                    {{-- TANGGAL LAHIR --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Tanggal Lahir
                        </label>
                        <input type="date"
                               name="tanggal_lahir"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                        <p class="text-[10px] text-slate-400 mt-0.5">Akan digunakan sebagai password awal akun GTK</p>
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Email
                        </label>
                        <input type="email"
                               name="email"
                               placeholder="contoh@email.com"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>

                    {{-- GELAR DEPAN --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Gelar Depan
                        </label>
                        <input type="text"
                               name="gelar_depan"
                               placeholder="mis. Drs."
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>

                    {{-- GELAR BELAKANG --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Gelar Belakang
                        </label>
                        <input type="text"
                               name="gelar_belakang"
                               placeholder="mis. M.Pd."
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>

                </div>

                {{-- SEKSI: DATA KEPEGAWAIAN --}}
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider pt-2 pb-0.5 border-b border-slate-100">
                    Data Kepegawaian
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    {{-- JENIS PEGAWAI --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Jenis Pegawai <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_pegawai"
                                required
                                class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 bg-white">
                            <option value="guru">Guru — Surat Kenaikan Gaji Berkala</option>
                            <option value="teknisi">Teknisi — Surat Keputusan</option>
                        </select>
                        <p class="text-[10px] text-slate-400 mt-0.5">Menentukan format dokumen SK yang diterbitkan</p>
                    </div>

                    {{-- JABATAN --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Jabatan
                        </label>
                        <input type="text"
                               name="jabatan"
                               placeholder="mis. Guru Ahli Madya"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>

                    {{-- GOLONGAN --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Pangkat / Golongan <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="pangkat_gol"
                               required
                               placeholder="mis. III/c"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>

                    {{-- GAJI --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Gaji Pokok Lama (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               name="gaji_pokok_lama"
                               required
                               min="0"
                               value="4200000"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>

                    {{-- MASA KERJA --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Masa Kerja Gol. (Tahun / Bulan) <span class="text-red-500">*</span>
                        </label>
                        <div class="flex space-x-2">
                            <input type="number"
                                   name="mkg_tahun"
                                   value="{{ old('mkg_tahun', 0) }}"
                                   placeholder="Thn"
                                   min="0"
                                   step="1"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                            <input type="number"
                                   name="mkg_bulan"
                                   value="{{ old('mkg_bulan', 0) }}"
                                   placeholder="Bln"
                                   min="0"
                                   max="11"
                                   step="1"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>

                    {{-- UNIT KERJA --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Unit Kerja / Sekolah <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="unit_kerja"
                               required
                               value="{{ $isSekolahRole ? (auth()->user()->unit_kerja ?? '') : '' }}"
                               placeholder="Nama sekolah / unit kerja"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>

                    {{-- TMT TERAKHIR --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            TMT KGB Terakhir <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                               name="tmt_kgb_terakhir"
                               required
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>

                    {{-- TMT YAD --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            TMT Jatuh Tempo (YAD) <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                               name="tmt_kgb_yad"
                               required
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">

                    <button type="button"
                            @click="openCreateModal = false"
                            class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold">

                        Batal

                    </button>

                    <button type="submit"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold">

                        Simpan & Buat Akun GTK

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>