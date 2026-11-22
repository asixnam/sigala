@props([
    'settings' => []
])

<div class="max-w-6xl mx-auto space-y-6"
     x-data="{
        activeTab: 'hero',

        // Modal Visibility
        modalDetail: false,
        modalEdit: false,
        modalAdd: false,

        modalType: '',
        modalItem: {},
        modalIndex: null,

        // Data Arrays
        heroSlides: {{ json_encode($settings['hero_slides'] ?? [
            ['badge' => 'Sistem Informasi Gaji Berkala (SIGALA)', 'title1' => 'Kemudahan Pengurusan', 'title2' => 'KGB GTK Blora', 'title3' => 'Secara Digital & Terintegrasi', 'desc' => 'SIGALA hadir sebagai solusi terpadu untuk memproses usulan Kenaikan Gaji Berkala (KGB) Guru dan Tenaga Kependidikan (GTK) di lingkungan Dinas Pendidikan Kabupaten Blora.', 'bg' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1920&auto=format&fit=crop'],
            ['badge' => 'Proses Otomatis & Real-Time', 'title1' => 'Pengajuan KGB Lebih', 'title2' => 'Gampang & Lancar', 'title3' => 'Tanpa Perlu Antrean Fisik', 'desc' => 'Layanan pengajuan Kenaikan Gaji Berkala kini jauh lebih cepat, terstruktur, dan terkomputerisasi secara efisien.', 'bg' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1920&auto=format&fit=crop'],
            ['badge' => 'Tanda Tangan Elektronik (TTE)', 'title1' => 'Legalitas KGB GTK', 'title2' => 'Sah & Aman', 'title3' => 'Dengan Tanda Tangan Digital', 'desc' => 'Integrasi Tanda Tangan Elektronik (TTE) menjamin keamanan, keaslian, dan legalitas penuh berkas KGB.', 'bg' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920&auto=format&fit=crop']
        ]) }},

        sambutanSlides: {{ json_encode($settings['sambutan_slides'] ?? [
            ['nama' => 'H. Arief Rohman, S.IP., M.Si.', 'jabatan' => 'Bupati Blora', 'subheading' => 'SAMBUTAN RESMI BUPATI BLORA', 'title' => 'Digitalisasi Layanan Kepegawaian Demi Mewujudkan Blora Berkelanjutan & Sejahtera', 'quote' => 'Melalui kehadiran Sistem Informasi Gaji Berkala (SIGALA), Pemerintah Kabupaten Blora berkomitmen memberikan pelayanan terbaik bagi para Guru dan Tenaga Kependidikan.', 'desc' => 'Transformasi digital ini merupakan wujud nyata reformasi birokrasi Dinas Pendidikan Kabupaten Blora dalam mempercepat hak-hak kepegawaian GTK.', 'foto' => 'img/logoblora.png'],
            ['nama' => 'Drs. Sunaryo, M.Pd.', 'jabatan' => 'Kepala Dinas Pendidikan Kab. Blora', 'subheading' => 'SAMBUTAN KEPALA DINAS PENDIDIKAN', 'title' => 'Layanan Publik Terpadu & Tanda Tangan Elektronik', 'quote' => 'SIGALA mempermudah pengajuan KGB GTK secara transparan dan akuntabel. Dengan dukungan TTE, penerbitan SK KGB kini berlangsung cepat.', 'desc' => 'Semoga aplikasi ini dapat mempermudah seluruh Guru dan Tenaga Kependidikan di Kabupaten Blora dalam pengurusan hak-hak kepegawaian.', 'foto' => 'img/logoblora.png']
        ]) }},

        features: {{ json_encode($settings['features'] ?? [
            ['icon' => '⚙️', 'icon_path' => '', 'title' => 'Otomatisasi Usulan', 'desc' => 'Sistem mendeteksi dan memproses usulan KGB secara otomatis 2 bulan sebelum jatuh tempo.'],
            ['icon' => '🔍', 'icon_path' => '', 'title' => '100% Transparan', 'desc' => 'Pantau status usulan secara real-time mulai dari verifikasi berkas hingga persetujuan akhir.'],
            ['icon' => '✍️', 'icon_path' => '', 'title' => 'Validasi & TTE', 'desc' => 'SK Kenaikan Gaji Berkala disahkan secara resmi menggunakan Tanda Tangan Elektronik (TTE).']
        ]) }},

        workflows: {{ json_encode($settings['workflows'] ?? [
            ['badge' => 'Tahap 01', 'title' => 'Input / Cek Data', 'desc' => 'Operator sekolah memeriksa data usulan GTK yang jatuh tempo.'],
            ['badge' => 'Tahap 02', 'title' => 'Verifikasi Berkas', 'desc' => 'Tim Pengelola Kepegawaian Dinas Pendidikan melakukan verifikasi kelengkapan syarat.'],
            ['badge' => 'Tahap 03', 'title' => 'Validasi & TTE', 'desc' => 'Persetujuan akhir dan pembubuhan Tanda Tangan Elektronik oleh Kepala Dinas.'],
            ['badge' => 'Tahap 04', 'title' => 'SK Terbit', 'desc' => 'SK KGB resmi dapat diunduh secara mandiri oleh GTK.']
        ]) }},

        // Live File Reader Helper for Modals
        handleFileSelect(event, fieldKey) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.modalItem[fieldKey] = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        handleCardFileSelect(event, type, index) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    if (type === 'hero') this.heroSlides[index].bg = e.target.result;
                    if (type === 'sambutan') this.sambutanSlides[index].foto = e.target.result;
                    if (type === 'feature') this.features[index].icon_path = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        // Open Detail Modal
        showDetail(type, item) {
            this.modalType = type;
            this.modalItem = JSON.parse(JSON.stringify(item));
            this.modalDetail = true;
        },

        // Open Edit Modal
        showEdit(type, item, index) {
            this.modalType = type;
            this.modalItem = JSON.parse(JSON.stringify(item));
            this.modalIndex = index;
            this.modalEdit = true;
        },

        // Save Edit
        saveEdit() {
            if (this.modalType === 'hero') this.heroSlides[this.modalIndex] = JSON.parse(JSON.stringify(this.modalItem));
            if (this.modalType === 'sambutan') this.sambutanSlides[this.modalIndex] = JSON.parse(JSON.stringify(this.modalItem));
            if (this.modalType === 'feature') this.features[this.modalIndex] = JSON.parse(JSON.stringify(this.modalItem));
            if (this.modalType === 'workflow') this.workflows[this.modalIndex] = JSON.parse(JSON.stringify(this.modalItem));
            this.modalEdit = false;
        },

        // Open Add Modal
showAdd(type) {
    this.modalType = type;
    this.modalItem = {};
    this.modalAdd = true;
},

// Save Add
saveAdd() {

    if (this.modalType === 'hero') {
        this.heroSlides.push({
            badge: this.modalItem.badge || '',
            title1: this.modalItem.title1 || '',
            title2: this.modalItem.title2 || '',
            title3: this.modalItem.title3 || '',
            desc: this.modalItem.desc || '',
            bg: this.modalItem.bg || ''
        });
    }

    if (this.modalType === 'sambutan') {
        this.sambutanSlides.push({
            nama: this.modalItem.nama || '',
            jabatan: this.modalItem.jabatan || '',
            subheading: this.modalItem.subheading || '',
            title: this.modalItem.title || '',
            quote: this.modalItem.quote || '',
            desc: this.modalItem.desc || '',
            foto: this.modalItem.foto || ''
        });
    }

    if (this.modalType === 'feature') {
        this.features.push({
            icon: this.modalItem.icon || '✨',
            icon_path: this.modalItem.icon_path || '',
            title: this.modalItem.title || '',
            desc: this.modalItem.desc || ''
        });
    }

    if (this.modalType === 'workflow') {
        this.workflows.push({
            badge: this.modalItem.badge || '',
            title: this.modalItem.title || '',
            desc: this.modalItem.desc || ''
        });
    }

    this.modalItem = {};
    this.modalAdd = false;
},

        // Delete Item
        removeItem(type, index) {
            if (confirm('Yakin ingin menghapus item ini?')) {
                if (type === 'hero') this.heroSlides.splice(index, 1);
                if (type === 'sambutan') this.sambutanSlides.splice(index, 1);
                if (type === 'feature') this.features.splice(index, 1);
                if (type === 'workflow') this.workflows.splice(index, 1);
            }
        }
     }">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs sm:text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">✕</button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="flex items-center justify-between flex-wrap gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">Pengaturan Tampilan Landing Page</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola banner hero slider, sambutan pejabat, kartu fitur unggulan, dan alur pelayanan SIGALA.</p>
        </div>
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="inline">
            @csrf
            <input type="hidden" name="hero_slides" :value="JSON.stringify(heroSlides)">
            <input type="hidden" name="sambutan_slides" :value="JSON.stringify(sambutanSlides)">
            <input type="hidden" name="features" :value="JSON.stringify(features)">
            <input type="hidden" name="workflows" :value="JSON.stringify(workflows)">

            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-md shadow-emerald-600/20 inline-flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                <span>Simpan Semua Pengaturan</span>
            </button>
        </form>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex space-x-2 border-b border-slate-200 overflow-x-auto pb-1">
        <button @click="activeTab = 'hero'" :class="activeTab === 'hero' ? 'border-emerald-600 text-emerald-600 font-bold bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'" class="px-4 py-2.5 border-b-2 rounded-t-xl text-xs whitespace-nowrap transition">
            🖼️ Hero Banner Slider (<span x-text="heroSlides.length"></span>)
        </button>
        <button @click="activeTab = 'sambutan'" :class="activeTab === 'sambutan' ? 'border-emerald-600 text-emerald-600 font-bold bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'" class="px-4 py-2.5 border-b-2 rounded-t-xl text-xs whitespace-nowrap transition">
            🗣️ Sambutan Pejabat (<span x-text="sambutanSlides.length"></span>)
        </button>
        <button @click="activeTab = 'features'" :class="activeTab === 'features' ? 'border-emerald-600 text-emerald-600 font-bold bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'" class="px-4 py-2.5 border-b-2 rounded-t-xl text-xs whitespace-nowrap transition">
            ✨ Fitur Unggulan (<span x-text="features.length"></span>)
        </button>
        <button @click="activeTab = 'workflows'" :class="activeTab === 'workflows' ? 'border-emerald-600 text-emerald-600 font-bold bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'" class="px-4 py-2.5 border-b-2 rounded-t-xl text-xs whitespace-nowrap transition">
            ⚡ Alur Pelayanan (<span x-text="workflows.length"></span>)
        </button>
    </div>

    <!-- TAB 1: HERO SLIDES -->
    <div x-show="activeTab === 'hero'" class="space-y-4">
        <div class="flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-800">Daftar Banner Hero Landing Page</h3>
            <button @click="showAdd('hero')" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold text-xs px-3 py-1.5 rounded-xl border border-emerald-200 transition inline-flex items-center space-x-1">
                <span>+ Tambah Banner Slide</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <template x-for="(slide, index) in heroSlides" :key="index">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between p-4 space-y-3">
                    <div class="relative h-32 rounded-xl overflow-hidden bg-slate-900 border border-slate-100">
                        <img :src="slide.bg" class="w-full h-full object-cover opacity-60">
                        <div class="absolute inset-0 p-3 flex flex-col justify-end text-white">
                            <span class="text-[9px] font-bold uppercase tracking-wider bg-emerald-500/80 px-2 py-0.5 rounded w-max" x-text="slide.badge"></span>
                            <h4 class="text-xs font-extrabold leading-tight mt-1" x-text="slide.title1 + ' ' + slide.title2"></h4>
                        </div>
                        <label class="absolute top-2 right-2 bg-slate-900/80 hover:bg-slate-900 text-white text-[10px] px-2 py-1 rounded-lg cursor-pointer border border-white/20 transition">
                            📷 Ganti Gambar
                            <input type="file" accept="image/*" class="hidden" @change="handleCardFileSelect($event, 'hero', index)">
                        </label>
                    </div>

                    <div class="text-xs space-y-1">
                        <div class="font-bold text-slate-800" x-text="slide.title3"></div>
                        <p class="text-slate-500 line-clamp-2 text-[11px]" x-text="slide.desc"></p>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-mono text-[10px]">Slide #<span x-text="index + 1"></span></span>
                        <div class="flex space-x-1.5">
                            <button @click="showDetail('hero', slide)" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-semibold">Detail</button>
                            <button @click="showEdit('hero', slide, index)" class="px-2 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-[11px] font-semibold">Edit</button>
                            <button @click="removeItem('hero', index)" class="px-2 py-1 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-[11px] font-semibold">Hapus</button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- TAB 2: SAMBUTAN SLIDES -->
    <div x-show="activeTab === 'sambutan'" class="space-y-4" style="display: none;">
        <div class="flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-800">Daftar Slide Sambutan Pejabat</h3>
            <button @click="showAdd('sambutan')" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold text-xs px-3 py-1.5 rounded-xl border border-emerald-200 transition inline-flex items-center space-x-1">
                <span>+ Tambah Sambutan</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <template x-for="(sambutan, index) in sambutanSlides" :key="index">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 flex flex-col justify-between space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="relative w-12 h-12 shrink-0">
                            <img :src="sambutan.foto" class="w-12 h-12 rounded-xl object-cover border border-slate-200">
                            <label class="absolute -bottom-1 -right-1 bg-slate-900 text-white text-[9px] p-0.5 rounded-full cursor-pointer hover:scale-110 transition" title="Ganti Foto">
                                📷
                                <input type="file" accept="image/*" class="hidden" @change="handleCardFileSelect($event, 'sambutan', index)">
                            </label>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900" x-text="sambutan.nama"></h4>
                            <p class="text-[11px] text-emerald-600 font-semibold" x-text="sambutan.jabatan"></p>
                        </div>
                    </div>

                    <div class="text-xs bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                        <div class="font-semibold text-slate-700 italic text-[11px] line-clamp-2">"<span x-text="sambutan.quote"></span>"</div>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-mono text-[10px]">Pejabat #<span x-text="index + 1"></span></span>
                        <div class="flex space-x-1.5">
                            <button @click="showDetail('sambutan', sambutan)" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-semibold">Detail</button>
                            <button @click="showEdit('sambutan', sambutan, index)" class="px-2 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-[11px] font-semibold">Edit</button>
                            <button @click="removeItem('sambutan', index)" class="px-2 py-1 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-[11px] font-semibold">Hapus</button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- TAB 3: FEATURES -->
    <div x-show="activeTab === 'features'" class="space-y-4" style="display: none;">
        <div class="flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-800">Daftar Fitur Unggulan</h3>
            <button @click="showAdd('feature')" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold text-xs px-3 py-1.5 rounded-xl border border-emerald-200 transition inline-flex items-center space-x-1">
                <span>+ Tambah Kartu Fitur</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <template x-for="(feat, index) in features" :key="index">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 space-y-2 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <template x-if="feat.icon_path">
                                <img :src="feat.icon_path" class="w-8 h-8 rounded-lg object-cover border border-slate-200">
                            </template>
                            <template x-if="!feat.icon_path">
                                <div class="text-2xl" x-text="feat.icon || '✨'"></div>
                            </template>
                        </div>
                        <label class="text-[10px] text-emerald-600 hover:underline font-semibold cursor-pointer">
                            Upload Ikon
                            <input type="file" accept="image/*" class="hidden" @change="handleCardFileSelect($event, 'feature', index)">
                        </label>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-900" x-text="feat.title"></h4>
                        <p class="text-[11px] text-slate-500 mt-0.5 leading-snug" x-text="feat.desc"></p>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-mono text-[10px]">Fitur #<span x-text="index + 1"></span></span>
                        <div class="flex space-x-1">
                            <button @click="showEdit('feature', feat, index)" class="px-2 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-[11px] font-semibold">Edit</button>
                            <button @click="removeItem('feature', index)" class="px-2 py-1 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-[11px] font-semibold">Hapus</button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- TAB 4: WORKFLOWS -->
    <div x-show="activeTab === 'workflows'" class="space-y-4" style="display: none;">
        <div class="flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-800">Daftar Langkah Alur Pelayanan</h3>
            <button @click="showAdd('workflow')" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold text-xs px-3 py-1.5 rounded-xl border border-emerald-200 transition inline-flex items-center space-x-1">
                <span>+ Tambah Tahap Alur</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <template x-for="(wf, index) in workflows" :key="index">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 space-y-2 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-emerald-700 uppercase bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200" x-text="wf.badge"></span>
                        <h4 class="text-xs font-bold text-slate-900 mt-2" x-text="wf.title"></h4>
                        <p class="text-[11px] text-slate-500 mt-0.5 leading-snug" x-text="wf.desc"></p>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-mono text-[10px]">Langkah #<span x-text="index + 1"></span></span>
                        <div class="flex space-x-1">
                            <button @click="showEdit('workflow', wf, index)" class="px-2 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-[11px] font-semibold">Edit</button>
                            <button @click="removeItem('workflow', index)" class="px-2 py-1 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-[11px] font-semibold">Hapus</button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- MODAL DETAIL -->
    <div x-show="modalDetail" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left" style="display: none;">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-bold text-slate-900 text-base">Detail Rincian Item</h3>
                <button @click="modalDetail = false" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
            </div>

            <div class="space-y-3 text-xs">
                <template x-for="(value, key) in modalItem" :key="key">
                    <div class="border-b border-slate-100 pb-2">
                        <span class="font-bold text-slate-400 uppercase text-[10px]" x-text="key"></span>
                        <template x-if="key.includes('bg') || key.includes('foto') || key.includes('icon_path')">
                            <img :src="value" class="w-full h-32 object-cover rounded-xl mt-1 border border-slate-200">
                        </template>
                        <template x-if="!key.includes('bg') && !key.includes('foto') && !key.includes('icon_path')">
                            <div class="text-slate-800 font-medium mt-0.5" x-text="value"></div>
                        </template>
                    </div>
                </template>
            </div>

            <div class="pt-2 flex justify-end">
                <button @click="modalDetail = false" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold">Tutup</button>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div x-show="modalEdit" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left" style="display: none;">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-bold text-slate-900 text-base">Edit Data Item</h3>
                <button @click="modalEdit = false" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
            </div>

            <form @submit.prevent="saveEdit()" class="space-y-3">
                <template x-for="(value, key) in modalItem" :key="key">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 capitalize" x-text="key.replace('_', ' ')"></label>

                        <!-- Special Image Upload Fields -->
                        <template x-if="key === 'bg' || key === 'foto' || key === 'icon_path'">
                            <div class="space-y-2">
                                <input type="text" x-model="modalItem[key]" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500" placeholder="URL atau upload file di bawah">
                                <input type="file" accept="image/*" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs bg-slate-50" @change="handleFileSelect($event, key)">
                            </div>
                        </template>

                        <!-- Long text fields -->
                        <template x-if="key === 'desc' || key === 'quote'">
                            <textarea x-model="modalItem[key]" rows="3" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500"></textarea>
                        </template>

                        <!-- Standard text fields -->
                        <template x-if="key !== 'bg' && key !== 'foto' && key !== 'icon_path' && key !== 'desc' && key !== 'quote'">
                            <input type="text" x-model="modalItem[key]" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                        </template>
                    </div>
                </template>

                <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">
                    <button type="button" @click="modalEdit = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL ADD -->
    <div x-show="modalAdd" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left" style="display: none;">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-bold text-slate-900 text-base">Tambah Item Baru</h3>
                <button @click="modalAdd = false" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
            </div>

            <form @submit.prevent="saveAdd()" class="space-y-3">
                
                <!-- Dynamic Form Fields according to Modal Type -->
                <template x-if="modalType === 'hero'">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Badge Tagline</label>
                            <input type="text" x-model="modalItem.badge" required placeholder="mis. Sistem Informasi Gaji Berkala" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Baris 1</label>
                            <input type="text" x-model="modalItem.title1" required placeholder="Kemudahan Pengurusan" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Baris 2 (Highlight Emerald)</label>
                            <input type="text" x-model="modalItem.title2" required placeholder="KGB GTK Blora" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Baris 3</label>
                            <input type="text" x-model="modalItem.title3" required placeholder="Secara Digital & Terintegrasi" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Singkat</label>
                            <textarea x-model="modalItem.desc" required rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Upload / URL Background Banner</label>
                            <input type="text" x-model="modalItem.bg" placeholder="https://..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs mb-1">
                            <input type="file" accept="image/*" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs bg-slate-50" @change="handleFileSelect($event, 'bg')">
                        </div>
                    </div>
                </template>

                <template x-if="modalType === 'sambutan'">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Pejabat</label>
                            <input type="text" x-model="modalItem.nama" required placeholder="H. Arief Rohman, S.IP., M.Si." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Jabatan</label>
                            <input type="text" x-model="modalItem.jabatan" required placeholder="Bupati Blora" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Subheading Banner</label>
                            <input type="text" x-model="modalItem.subheading" required placeholder="SAMBUTAN RESMI BUPATI BLORA" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Sambutan</label>
                            <input type="text" x-model="modalItem.title" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Kutipan Utama (Quote)</label>
                            <textarea x-model="modalItem.quote" required rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Lengkap Sambutan</label>
                            <textarea x-model="modalItem.desc" required rows="3" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Upload / Path Foto Pejabat</label>
                            <input type="text" x-model="modalItem.foto" placeholder="img/logoblora.png" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs mb-1">
                            <input type="file" accept="image/*" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs bg-slate-50" @change="handleFileSelect($event, 'foto')">
                        </div>
                    </div>
                </template>

                <template x-if="modalType === 'feature'">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Emoji / Simbol Icon</label>
                            <input type="text" x-model="modalItem.icon" placeholder="⚙️" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Upload File Icon Vector / Gambar</label>
                            <input type="file" accept="image/*" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs bg-slate-50" @change="handleFileSelect($event, 'icon_path')">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Fitur</label>
                            <input type="text" x-model="modalItem.title" required placeholder="Otomatisasi Usulan" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Fitur</label>
                            <textarea x-model="modalItem.desc" required rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                        </div>
                    </div>
                </template>

                <template x-if="modalType === 'workflow'">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Badge Tahap</label>
                            <input type="text" x-model="modalItem.badge" required placeholder="Tahap 01" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Langkah</label>
                            <input type="text" x-model="modalItem.title" required placeholder="Input / Cek Data" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Langkah</label>
                            <textarea x-model="modalItem.desc" required rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                        </div>
                    </div>
                </template>

                <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">
                    <button type="button" @click="modalAdd = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold">Tambah Item</button>
                </div>
            </form>
        </div>
    </div>

</div>
