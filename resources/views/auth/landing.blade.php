<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGALA - Sistem Informasi Gaji Berkala Dinas Pendidikan Kab. Blora</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logoblora.png') }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk interaktivitas Slider & Modal -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ openLogin: false }">

    <!-- Navbar Minimalis -->
    <x-header />

@php
    $heroSlidesList = $settings['hero_slides'] ?? [
        ['badge' => $settings['hero_slide1_badge'] ?? 'Sistem Informasi Gaji Berkala (SIGALA)', 'title1' => $settings['hero_slide1_title1'] ?? 'Kemudahan Pengurusan', 'title2' => $settings['hero_slide1_title2'] ?? 'KGB GTK Blora', 'title3' => $settings['hero_slide1_title3'] ?? 'Secara Digital & Terintegrasi', 'desc' => $settings['hero_slide1_desc'] ?? 'SIGALA hadir sebagai solusi terpadu untuk memproses usulan Kenaikan Gaji Berkala (KGB) Guru dan Tenaga Kependidikan (GTK) di lingkungan Dinas Pendidikan Kabupaten Blora secara elektronik.', 'bg' => $settings['hero_slide1_bg'] ?? 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1920&auto=format&fit=crop'],
        ['badge' => $settings['hero_slide2_badge'] ?? 'Proses Otomatis & Real-Time', 'title1' => $settings['hero_slide2_title1'] ?? 'Pengajuan KGB Lebih', 'title2' => $settings['hero_slide2_title2'] ?? 'Gampang & Lancar', 'title3' => $settings['hero_slide2_title3'] ?? 'Tanpa Perlu Antrean Fisik', 'desc' => $settings['hero_slide2_desc'] ?? 'Layanan pengajuan Kenaikan Gaji Berkala kini jauh lebih cepat, terstruktur, dan terkomputerisasi secara efisien.', 'bg' => $settings['hero_slide2_bg'] ?? 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1920&auto=format&fit=crop'],
        ['badge' => $settings['hero_slide3_badge'] ?? 'Tanda Tangan Elektronik (TTE)', 'title1' => $settings['hero_slide3_title1'] ?? 'Legalitas KGB GTK', 'title2' => $settings['hero_slide3_title2'] ?? 'Sah & Aman', 'title3' => $settings['hero_slide3_title3'] ?? 'Dengan Tanda Tangan Digital', 'desc' => $settings['hero_slide3_desc'] ?? 'Integrasi Tanda Tangan Elektronik (TTE) menjamin keamanan, keaslian, dan legalitas penuh berkas KGB Guru dan Tenaga Kependidikan.', 'bg' => $settings['hero_slide3_bg'] ?? 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920&auto=format&fit=crop']
    ];

    $sambutanSlidesList = $settings['sambutan_slides'] ?? [];

if (empty($sambutanSlidesList)) {
    $sambutanSlidesList = [
        [
            'nama'       => $settings['bupati_nama'] ?? 'H. Arief Rohman, S.IP., M.Si.',
            'jabatan'    => $settings['bupati_jabatan'] ?? 'Bupati Blora',
            'subheading' => $settings['bupati_subheading'] ?? 'SAMBUTAN RESMI BUPATI BLORA',
            'title'      => $settings['bupati_title'] ?? 'Digitalisasi Layanan Kepegawaian Demi Mewujudkan Blora Berkelanjutan & Sejahtera',
            'quote'      => $settings['bupati_quote'] ?? 'Melalui kehadiran Sistem Informasi Gaji Berkala (SIGALA), Pemerintah Kabupaten Blora berkomitmen memberikan pelayanan terbaik bagi para Guru dan Tenaga Kependidikan.',
            'desc'       => $settings['bupati_desc'] ?? 'Transformasi digital ini merupakan wujud nyata reformasi birokrasi Dinas Pendidikan Kabupaten Blora dalam mempercepat hak-hak kepegawaian GTK.',
            'foto'       => $settings['bupati_foto'] ?? 'img/logoblora.png',
        ],
        [
            'nama'       => $settings['kadis_nama'] ?? 'SUNARYO, S.Pd., M.Si.',
            'jabatan'    => $settings['kadis_jabatan'] ?? 'Kepala Dinas Pendidikan Kab. Blora',
            'subheading' => $settings['kadis_subheading'] ?? 'SAMBUTAN KEPALA DINAS PENDIDIKAN',
            'title'      => $settings['kadis_title'] ?? 'Layanan Publik Terpadu & Tanda Tangan Elektronik',
            'quote'      => $settings['kadis_quote'] ?? 'SIGALA mempermudah pengajuan KGB GTK secara transparan dan akuntabel. Dengan dukungan TTE, penerbitan SK KGB kini berlangsung cepat.',
            'desc'       => $settings['kadis_desc'] ?? 'Semoga aplikasi ini dapat mempermudah seluruh Guru dan Tenaga Kependidikan di Kabupaten Blora.',
            'foto'       => $settings['kadis_foto'] ?? 'img/logoblora.png',
        ],
    ];
}

    $featuresList = $settings['features'] ?? [
        ['type' => 'auto', 'title' => $settings['feature1_title'] ?? 'Otomatisasi Usulan', 'desc' => $settings['feature1_desc'] ?? 'Sistem mendeteksi dan memproses usulan KGB secara otomatis 2 bulan sebelum jatuh tempo.'],
        ['type' => 'transparent', 'title' => $settings['feature2_title'] ?? '100% Transparan', 'desc' => $settings['feature2_desc'] ?? 'Pantau status usulan secara real-time mulai dari verifikasi berkas hingga persetujuan akhir.'],
        ['type' => 'tte', 'title' => $settings['feature3_title'] ?? 'Validasi & TTE', 'desc' => $settings['feature3_desc'] ?? 'SK Kenaikan Gaji Berkala disahkan secara resmi menggunakan Tanda Tangan Elektronik (TTE).']
    ];

    $workflowsList = $settings['workflows'] ?? [
        ['badge' => $settings['workflow1_badge'] ?? 'Tahap 01', 'title' => $settings['workflow1_title'] ?? 'Input / Cek Data', 'desc' => $settings['workflow1_desc'] ?? 'Operator sekolah memeriksa data usulan GTK yang jatuh tempo.'],
        ['badge' => $settings['workflow2_badge'] ?? 'Tahap 02', 'title' => $settings['workflow2_title'] ?? 'Verifikasi Berkas', 'desc' => $settings['workflow2_desc'] ?? 'Tim Pengelola Kepegawaian Dinas Pendidikan melakukan verifikasi kelengkapan syarat.'],
        ['badge' => $settings['workflow3_badge'] ?? 'Tahap 03', 'title' => $settings['workflow3_title'] ?? 'Validasi & TTE', 'desc' => $settings['workflow3_desc'] ?? 'Persetujuan akhir dan pembubuhan Tanda Tangan Elektronik oleh Kepala Dinas.'],
        ['badge' => $settings['workflow4_badge'] ?? 'Tahap 04', 'title' => $settings['workflow4_title'] ?? 'SK Terbit', 'desc' => $settings['workflow4_desc'] ?? 'SK KGB resmi dapat diunduh secara mandiri oleh GTK.']
    ];
@endphp

@php
    $totalSekolah = $totalSekolah ?? (\App\Models\User::where('role', 'admin_sekolah')->count() ?: \App\Models\Pegawai::whereNotNull('unit_kerja')->where('unit_kerja', '!=', '')->distinct('unit_kerja')->count('unit_kerja'));
    $totalGuru = $totalGuru ?? \App\Models\Pegawai::count();
@endphp

    <!-- A. HERO SECTION (DYNAMIC SLIDER) -->
    <section id="home" class="relative w-full min-h-screen overflow-hidden flex items-center"
             x-data="{ 
                activeSlide: 1, 
                totalSlides: {{ count($heroSlidesList) }}, 
                init() { 
                    setInterval(() => { 
                        this.activeSlide = this.activeSlide === this.totalSlides ? 1 : this.activeSlide + 1; 
                    }, 6000); 
                } 
             }">
        
        @foreach($heroSlidesList as $index => $hs)
        @php
            $slideNo = $index + 1;
            $bgSrc = $hs['bg'] ?? '';
            $isBgLocal = $bgSrc && !str_starts_with($bgSrc, 'http');
            $fullBgUrl = $isBgLocal ? asset($bgSrc) : $bgSrc;
        @endphp
        <div class="absolute inset-0 transition-opacity duration-1000 flex items-center text-white pt-20 pb-16"
             :class="activeSlide === {{ $slideNo }} ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none'"
             style="background-image: url('{{ $fullBgUrl }}'); background-size: cover; background-position: center;">
            
            <!-- Overlay Netral Halus untuk Keterbacaan Teks Tanpa Warna Solid -->
            <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-slate-950/85 via-slate-950/60 to-slate-900/40 backdrop-blur-[0.5px]"></div>

            <div class="relative z-10 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
                    
                    <!-- Kolom Kiri: Teks Judul, Deskripsi & Tombol Aksi -->
                    <div class="lg:col-span-7 space-y-5 sm:space-y-6 text-center sm:text-left mx-auto sm:mx-0">
                        <div class="space-y-3">
                            <div class="flex items-center justify-center sm:justify-start">
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-yellow-400/20 text-yellow-300 border border-yellow-400/30 text-xs font-bold rounded-full uppercase tracking-wider backdrop-blur-sm shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span>
                                    {{ $hs['badge'] ?? 'Sistem Informasi Gaji Berkala (SIGALA)' }}
                                </span>
                            </div>
                            <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight text-white drop-shadow-sm">
                                <span class="block">{{ $hs['title1'] ?? '' }}</span>
                                <span class="relative inline-block pb-1 sm:pb-2 border-b-4 border-yellow-400 text-2xl sm:text-4xl md:text-5xl lg:text-6xl text-yellow-300">{{ $hs['title2'] ?? '' }}</span>
                                <br> {{ $hs['title3'] ?? '' }}
                            </h1>
                        </div>
                        <p class="text-xs sm:text-base md:text-lg text-slate-200 leading-relaxed max-w-2xl mx-auto sm:mx-0 text-justify sm:text-left drop-shadow-sm font-normal">
                            {{ $hs['desc'] ?? '' }}
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-3 pt-3 sm:pt-4 w-full sm:w-auto">
                            <button @click="openLogin = true" class="w-full sm:w-auto bg-yellow-400 hover:bg-yellow-300 text-slate-950 font-bold py-3.5 px-7 rounded-xl transition-all duration-300 transform hover:scale-[1.02] inline-flex items-center justify-center text-xs uppercase tracking-wider shadow-xl whitespace-nowrap">
                                <span>Masuk Aplikasi</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                            <a href="#fitur" class="w-full sm:w-auto bg-white/15 hover:bg-white/25 text-white border border-white/30 font-bold py-3.5 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] inline-flex items-center justify-center text-xs uppercase tracking-wider whitespace-nowrap backdrop-blur-sm">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>

                    <!-- Kolom Kanan Bawah: Kartu Statistik Sekolah & Guru + Logo BerAKHLAK & Bangga Melayani Bangsa -->
                    <div class="lg:col-span-5 flex flex-col items-center lg:items-end justify-center space-y-4 pt-4 lg:pt-0 w-full">
                        
                        <!-- Kartu Statistik Sekolah & Guru -->
                        <div class="w-full max-w-md bg-white/15 backdrop-blur-md rounded-2xl border border-white/25 p-4 sm:p-5 shadow-2xl">
                            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                <!-- Stat Sekolah -->
                                <div class="bg-black/20 hover:bg-black/30 transition rounded-xl p-3.5 border border-white/15 text-center sm:text-left">
                                    <div class="flex items-center justify-center sm:justify-start gap-2 mb-1.5">
                                        <div class="w-7 h-7 rounded-lg bg-yellow-400/20 text-yellow-300 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <span class="text-[11px] font-semibold text-slate-200 uppercase tracking-wider">Sekolah</span>
                                    </div>
                                    <div class="text-2xl sm:text-3xl font-extrabold text-white">{{ number_format($totalSekolah, 0, ',', '.') }}</div>
                                    <p class="text-[10px] text-slate-300 mt-0.5">Satuan Pendidikan</p>
                                </div>

                                <!-- Stat Guru / Pegawai -->
                                <div class="bg-black/20 hover:bg-black/30 transition rounded-xl p-3.5 border border-white/15 text-center sm:text-left">
                                    <div class="flex items-center justify-center sm:justify-start gap-2 mb-1.5">
                                        <div class="w-7 h-7 rounded-lg bg-emerald-400/20 text-emerald-300 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <span class="text-[11px] font-semibold text-slate-200 uppercase tracking-wider">Guru & GTK</span>
                                    </div>
                                    <div class="text-2xl sm:text-3xl font-extrabold text-white">{{ number_format($totalGuru, 0, ',', '.') }}</div>
                                    <p class="text-[10px] text-slate-300 mt-0.5">Pegawai Terdaftar</p>
                                </div>
                            </div>
                        </div>

                        <!-- Kartu Logo BerAKHLAK & Bangga Melayani Bangsa -->
                        <div class="w-full max-w-md bg-white/95 backdrop-blur-md rounded-2xl border border-white/40 p-3 sm:p-4 shadow-xl flex items-center justify-around gap-4">
                            <img src="{{ asset('img/ahlak.png') }}" alt="BerAKHLAK" class="h-8 sm:h-10 w-auto object-contain hover:scale-105 transition-transform duration-300">
                            <div class="h-7 w-px bg-slate-300/80"></div>
                            <img src="{{ asset('img/bangga.png') }}" alt="Bangga Melayani Bangsa" class="h-8 sm:h-10 w-auto object-contain hover:scale-105 transition-transform duration-300">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Slider Indicators -->
        <div class="absolute bottom-6 left-0 right-0 z-30 flex justify-center space-x-2.5">
            <template x-for="slide in totalSlides">
                <button @click="activeSlide = slide" 
                        class="h-2.5 rounded-full transition-all duration-300"
                        :class="activeSlide === slide ? 'bg-yellow-400 w-8' : 'bg-white/40 hover:bg-white/70 w-2.5'">
                </button>
            </template>
        </div>
    </section>

    <!-- B. SAMBUTAN SLIDER (DYNAMIC SLIDES) -->
    <section id="sambutan" class="py-12 sm:py-16 bg-slate-50/50 border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200/80 shadow-sm relative"
                 x-data="{
                    activeSambutan: 1,
                    totalSambutan: {{ count($sambutanSlidesList) }},
                    init() {
                        setInterval(() => {
                            this.activeSambutan = this.activeSambutan === this.totalSambutan ? 1 : this.activeSambutan + 1;
                        }, 9000);
                    }
                 }">
                
                <!-- Navigation Buttons (Top Right) -->
                <div class="absolute top-6 sm:top-8 right-6 sm:right-8 z-20 flex items-center space-x-2">
                    <button @click="activeSambutan = activeSambutan === 1 ? totalSambutan : activeSambutan - 1" 
                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-slate-900 hover:border-slate-300 flex items-center justify-center transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="activeSambutan = activeSambutan === totalSambutan ? 1 : activeSambutan + 1" 
                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-slate-900 hover:border-slate-300 flex items-center justify-center transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                @foreach($sambutanSlidesList as $index => $ss)
                @php
                    $sNo = $index + 1;
                    $fotoSrc = $ss['foto'] ?? 'img/logoblora.png';
                    $isFotoLocal = !str_starts_with($fotoSrc, 'http');
                    $fullFotoUrl = $isFotoLocal ? asset($fotoSrc) : $fotoSrc;
                @endphp
                <div x-show="activeSambutan === {{ $sNo }}" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 transform translate-x-4"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     class="flex flex-col md:flex-row items-center md:items-start gap-6 sm:gap-10">
                    
                    <!-- Foto & Identitas -->
                    <div class="shrink-0 text-center space-y-2">
                        <div class="w-36 h-36 sm:w-48 sm:h-48 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200/80 shadow-sm mx-auto">
                            <img src="{{ $fullFotoUrl }}" 
                                 alt="{{ $ss['nama'] ?? 'Tokoh' }}" 
                                 class="w-full h-full object-cover object-top">
                        </div>
                        <div class="pt-1">
                            <h4 class="font-extrabold text-slate-900 text-base sm:text-lg leading-tight">{{ $ss['nama'] ?? '' }}</h4>
                            <p class="text-xs sm:text-sm text-emerald-600 font-semibold mt-0.5">{{ $ss['jabatan'] ?? '' }}</p>
                        </div>
                    </div>

                    <!-- Pesan Sambutan -->
                    <div class="space-y-4 text-slate-700 text-center md:text-left flex-1 pr-0 md:pr-14">
                        <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider bg-emerald-100/80 px-3.5 py-1.5 rounded-lg inline-block">
                            {{ $ss['subheading'] ?? 'SAMBUTAN RESMI' }}
                        </span>
                        
                        <h3 class="text-lg sm:text-2xl font-extrabold text-slate-900 leading-snug">
                            "{{ $ss['title'] ?? '' }}"
                        </h3>

                        <div class="border-l-2 border-emerald-500 pl-4 py-0.5 text-left">
                            <p class="text-xs sm:text-sm text-slate-600 italic leading-relaxed">
                                "{{ $ss['quote'] ?? '' }}"
                            </p>
                        </div>

                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed text-justify md:text-left">
                            {{ $ss['desc'] ?? '' }}
                        </p>
                    </div>
                </div>
                @endforeach

                <!-- Footer Separator Line & Slide Indicators -->
                <div class="border-t border-slate-100 pt-5 mt-6 flex items-center space-x-2">
                    <template x-for="slide in totalSambutan">
                        <button @click="activeSambutan = slide" 
                                class="h-2 rounded-full transition-all duration-300"
                                :class="activeSambutan === slide ? 'bg-emerald-600 w-6' : 'bg-slate-300 hover:bg-slate-400 w-2'">
                        </button>
                    </template>
                </div>

            </div>
        </div>
    </section>

    <!-- C. FITUR UTAMA (DYNAMIC LIST WITH MODERN SVG ICONS) -->
    <section id="fitur" class="py-16 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
                <h2 class="text-2xl sm:text-4xl font-bold tracking-tight text-slate-900">{{ $settings['features_header_title'] ?? 'Keunggulan SIGALA' }}</h2>
                <p class="mt-3 sm:mt-4 text-xs sm:text-base text-slate-600">{{ $settings['features_header_subtitle'] ?? 'Dirancang khusus untuk menghadirkan pelayanan administrasi kepegawaian yang modern, cepat, dan akuntabel.' }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                @foreach($featuresList as $fIdx => $ft)
                <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold text-xl mb-6 overflow-hidden border border-emerald-200 shrink-0">
                        @if(isset($ft['type']) && $ft['type'] === 'auto')
                            <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        @elseif(isset($ft['type']) && $ft['type'] === 'transparent')
                            <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        @elseif(isset($ft['type']) && $ft['type'] === 'tte')
                            <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        @endif
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-slate-900 mb-2 sm:mb-3">{{ $ft['title'] ?? '' }}</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        {{ $ft['desc'] ?? '' }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- D. ALUR LAYANAN (DYNAMIC WORKFLOW LIST) -->
    <section id="alur" class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
                <h2 class="text-2xl sm:text-4xl font-bold tracking-tight text-slate-900">{{ $settings['workflow_header_title'] ?? 'Alur Layanan Usulan KGB' }}</h2>
                <p class="mt-3 sm:mt-4 text-xs sm:text-base text-slate-600">{{ $settings['workflow_header_subtitle'] ?? 'Tahapan mudah dan terstruktur dari sekolah hingga terbit SK TTE.' }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
                @foreach($workflowsList as $wf)
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm relative">
                    <div class="text-xs font-bold text-emerald-600 mb-2 uppercase tracking-wider">{{ $wf['badge'] ?? '' }}</div>
                    <h4 class="font-bold text-slate-900 text-base sm:text-lg mb-2">{{ $wf['title'] ?? '' }}</h4>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $wf['desc'] ?? '' }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- E. KONTAK & FOOTER WITH SVG ICONS -->
    <section id="kontak" class="bg-slate-900 text-slate-300 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                
                <!-- Div Kiri: Peta Lokasi -->
                <div class="w-full h-72 sm:h-80 rounded-2xl overflow-hidden border border-slate-800 shadow-lg">
                    <iframe 
                        src="{{ $settings['contact_map_url'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.688800971032!2d111.4172!3d-6.9731!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e773c3333333333%3A0x3333333333333333!2sJl.%20Dr.%20Soetomo%20No.42%2C%20Blora%2C%20Kec.%20Blora%2C%20Kabupaten%20Blora%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1650000000000!5m2!1sid!2sid' }}" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <!-- Div Kanan: Informasi Kontak & Helpdesk -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold text-white mb-2">{{ $settings['contact_instansi'] ?? 'Dinas Pendidikan Kabupaten Blora' }}</h3>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                            {{ $settings['contact_address'] ?? 'Jl. Ahmad Yani Nomor 42, Blora, Kabupaten Blora, Jawa Tengah' }}
                        </p>
                    </div>

                    <div class="space-y-3.5 border-t border-slate-800 pt-6">
                        <div class="flex items-center space-x-3 text-xs sm:text-sm">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-emerald-400 font-semibold">Telepon:</span>
                            <span>{{ $settings['contact_phone'] ?? '(0296) 5311xx' }}</span>
                        </div>
                        <div class="flex items-center space-x-3 text-xs sm:text-sm">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-emerald-400 font-semibold">Email:</span>
                            <span>{{ $settings['contact_email'] ?? 'diknas@blorakab.go.id' }}</span>
                        </div>
                        <div class="flex items-center space-x-3 text-xs sm:text-sm">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-emerald-400 font-semibold">Jam Layanan:</span>
                            <span>{{ $settings['contact_hours'] ?? 'Senin - Kamis (07.30 - 15.30 WIB), Jumat (07.30 - 14.00 WIB)' }}</span>
                        </div>
                    </div>

                    <div class="border-t border-slate-800 pt-6 text-[11px] sm:text-xs text-slate-500">
                        {{ $settings['landing_footer_copy'] ?? '© 2026 Dinas Pendidikan Kabupaten Blora. Hak Cipta Dilindungi Undang-Undang.' }}
                    </div>
                </div>

            </div>
        </div>
    </section>

<!-- MODAL FORM LOGIN DENGAN PENGAMANAN STATE ERROR & RESPONSIVE SCROLL -->
<div x-show="openLogin" 
     class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4"
     x-transition.opacity
     style="display: none;"
     x-data="{
        authView: 'login', // 'login', 'forgot_request', 'forgot_verify'
        loginMode: 'manual', // 'manual', 'google'
        captchaInput: '',
        num1: 0,
        num2: 0,
        generateCaptcha() {
            this.num1 = Math.floor(Math.random() * 5) + 1;
            this.num2 = Math.floor(Math.random() * 4) + 1;
            this.captchaInput = '';
        },

        // State Verifikasi Keamanan Khusus Google Login
        showGoogleVerify: false,
        googleNum1: 0,
        googleNum2: 0,
        googleCaptchaInput: '',
        googleSliderValue: 0,
        googleVerified: false,
        googleRedirecting: false,

        generateGoogleCaptcha() {
            this.googleNum1 = Math.floor(Math.random() * 6) + 2;
            this.googleNum2 = Math.floor(Math.random() * 5) + 1;
            this.googleCaptchaInput = '';
            this.googleSliderValue = 0;
            this.googleVerified = false;
            this.googleRedirecting = false;
        },

        openGoogleVerification() {
            this.loginMode = 'google';
            this.generateGoogleCaptcha();
            this.showGoogleVerify = true;
        },

        closeGoogleVerification() {
            this.loginMode = 'manual';
            this.showGoogleVerify = false;
        },

        processGoogleLogin() {
            const expected = this.googleNum1 + this.googleNum2;
            if (parseInt(this.googleCaptchaInput) !== expected && this.googleSliderValue < 90) {
                alert('Silakan lengkapi verifikasi keamanan dengan benar.');
                return;
            }
            this.googleVerified = true;
            this.googleRedirecting = true;
            setTimeout(() => {
                window.location.href = '{{ route('auth.google') }}';
            }, 600);
        },

        // State Lupa Password & OTP
        forgotIdentifier: '',
        forgotOtp: '',
        forgotPassword: '',
        forgotPasswordConfirmation: '',
        forgotLoading: false,
        forgotError: '',
        forgotSuccess: '',
        forgotMaskedEmail: '',
        forgotDevOtp: null,

        openForgotPassword() {
            this.authView = 'forgot_request';
            this.forgotError = '';
            this.forgotSuccess = '';
            this.forgotOtp = '';
            this.forgotPassword = '';
            this.forgotPasswordConfirmation = '';
        },

        async sendForgotOtp() {
            if (!this.forgotIdentifier.trim()) {
                this.forgotError = 'Silakan masukkan NIP, Email, atau Username Anda.';
                return;
            }
            this.forgotLoading = true;
            this.forgotError = '';
            this.forgotSuccess = '';

            try {
                const response = await fetch('{{ route('password.otp.send') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ identifier: this.forgotIdentifier })
                });
                const res = await response.json();
                this.forgotLoading = false;

                if (res.success) {
                    this.forgotSuccess = res.message;
                    this.forgotMaskedEmail = res.masked_email || '';
                    this.forgotDevOtp = res.dev_otp || null;
                    this.authView = 'forgot_verify';
                } else {
                    this.forgotError = res.message || 'Gagal mengirimkan kode OTP.';
                }
            } catch (err) {
                this.forgotLoading = false;
                this.forgotError = 'Terjadi kendala jaringan saat menghubungi server.';
            }
        },

        async verifyOtpAndReset() {
            if (!this.forgotOtp || this.forgotOtp.length !== 6) {
                this.forgotError = 'Kode OTP harus berupa 6 digit angka.';
                return;
            }
            if (!this.forgotPassword || this.forgotPassword.length < 6) {
                this.forgotError = 'Kata sandi baru minimal 6 karakter.';
                return;
            }
            if (this.forgotPassword !== this.forgotPasswordConfirmation) {
                this.forgotError = 'Konfirmasi kata sandi baru tidak sesuai.';
                return;
            }

            this.forgotLoading = true;
            this.forgotError = '';

            try {
                const response = await fetch('{{ route('password.otp.verify') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        identifier: this.forgotIdentifier,
                        otp: this.forgotOtp,
                        password: this.forgotPassword,
                        password_confirmation: this.forgotPasswordConfirmation
                    })
                });
                const res = await response.json();
                this.forgotLoading = false;

                if (res.success) {
                    alert('✓ ' + res.message);
                    this.authView = 'login';
                    this.forgotSuccess = res.message;
                    this.forgotError = '';
                } else {
                    this.forgotError = res.message || 'Kode OTP salah atau telah kedaluwarsa.';
                }
            } catch (err) {
                this.forgotLoading = false;
                this.forgotError = 'Terjadi kesalahan sistem saat menyimpan kata sandi.';
            }
        },

        init() {
            // Jika Laravel mendeteksi error saat halaman reload, otomatis buka modal
            @if(session('error') || $errors->any())
                this.openLogin = true;
            @endif

            this.$watch('openLogin', value => {
                if (value) { 
                    this.generateCaptcha();
                    this.showGoogleVerify = false;
                    this.loginMode = 'manual';
                    this.authView = 'login';
                }
            });
        }
     }">
    
    <div class="bg-white max-w-4xl lg:max-w-5xl w-full p-5 sm:p-7 lg:p-9 relative border border-slate-100 max-h-[94vh] overflow-y-auto"
         x-transition>
        
        <!-- Tombol Close Minimalis Modern -->
        <button @click="openLogin = false" type="button" class="absolute top-4 right-4 z-20 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center font-bold text-xs transition">
            ✕
        </button>

        <!-- GRID 2 SISI (SPLIT VIEW CARD MODERN) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">
            
            <!-- SISI KIRI (FORM PANEL) -->
            <div class="lg:col-span-7 flex flex-col justify-center">

                <!-- Header Modal Sisi Kiri -->
                <div class="mb-5">
                    <div class="flex items-center space-x-2.5 mb-2.5">
                        <img src="{{ asset('img/logoblora.png') }}" alt="Logo Blora" class="h-7 w-auto object-contain">
                        <div class="h-4 w-px bg-slate-200"></div>
                        <img src="{{ asset('img/dindik.png') }}" alt="Logo DINDIK" class="h-7 w-auto object-contain brightness-0">
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 uppercase tracking-wider ml-1">KAB. BLORA</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Masuk</h3>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Sistem Informasi Kenaikan Gaji Berkala (SIGALA)</p>
                </div>

                <!-- 1. PESAN ERROR LARAVEL -->
                @if(session('error'))
                    <div class="mb-4 p-3.5 bg-red-50 border border-red-200 text-red-700 text-xs rounded-2xl flex items-start space-x-2.5 shadow-sm">
                        <svg class="w-4 h-4 text-red-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div class="leading-relaxed">{{ session('error') }}</div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-3.5 bg-red-50 border border-red-200 text-red-700 text-xs rounded-2xl space-y-1 shadow-sm">
                        <div class="font-bold flex items-center space-x-1.5 text-red-800">
                            <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span>Terjadi Kesalahan:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-0.5 pl-1 text-[11px]">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- ALERT SUKSES RESET PASSWORD DARI JS -->
                <div x-show="forgotSuccess && authView === 'login'" x-cloak class="mb-4 p-3.5 bg-emerald-50 border border-emerald-300 text-emerald-800 text-xs rounded-2xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-2">
                        <span class="text-emerald-600 font-bold text-sm">✓</span>
                        <span x-text="forgotSuccess" class="font-medium"></span>
                    </div>
                    <button type="button" @click="forgotSuccess = ''" class="text-emerald-500 hover:text-emerald-700 font-bold text-xs p-1">✕</button>
                </div>

        {{-- =========================================================================
             BAGIAN LOGIN: GOOGLE & MANUAL (Tampil jika authView === 'login')
        ========================================================================== --}}
        <div x-show="authView === 'login'" x-transition>
            
            {{-- =========================================================================
                 MODE 1: LOGIN MANUAL (NIP / USERNAME & PASSWORD)
            ========================================================================== --}}
            <div x-show="loginMode === 'manual'" x-transition>
                <form action="{{ route('login.authenticate') }}" method="POST" class="space-y-3.5" 
                      @submit="if (parseInt(captchaInput) !== (num1 + num2)) { alert('Jawaban verifikasi keamanan salah! Silakan coba lagi.'); $event.preventDefault(); }">
                    
                    @csrf

                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1">NIP / Email Sekolah / Username</label>
                        <input type="text" name="username" required value="{{ old('username') }}" placeholder="Contoh: 198505122010011001 atau sekolah@sigala.test" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-xs sm:text-sm">
                    </div>
                    
                    <div x-data="{ showPassword: false }">
                        <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1">Kata Sandi</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" 
                                   id="landing-password"
                                   type="password" 
                                   name="password" 
                                   required 
                                   placeholder="••••••••" 
                                   class="w-full px-4 py-2.5 pr-10 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-xs sm:text-sm">
                            <button type="button" 
                                    @click="showPassword = !showPassword"
                                    onclick="
                                        const input = document.getElementById('landing-password');
                                        const eyeShow = document.getElementById('landing-eye-show');
                                        const eyeHide = document.getElementById('landing-eye-hide');
                                        if (input.type === 'password') {
                                            input.type = 'text';
                                            eyeShow.classList.add('hidden');
                                            eyeHide.classList.remove('hidden');
                                        } else {
                                            input.type = 'password';
                                            eyeShow.classList.remove('hidden');
                                            eyeHide.classList.add('hidden');
                                        }
                                    "
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 focus:outline-none"
                                    aria-label="Toggle password visibility">
                                <!-- Eye Icon (Hide Password State) -->
                                <svg x-show="!showPassword" id="landing-eye-show" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12c.077-.133.152-.27.225-.412C3.257 9.873 6.945 6 12 6s8.743 3.873 9.739 5.588c.073.142.148.279.225.412-.077.133-.152.27-.225.412C20.743 14.127 17.055 18 12 18s-8.743-3.873-9.739-5.588a18.45 18.45 0 0 1-.225-.412Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <!-- Eye Slash Icon (Show Password State) -->
                                <svg x-show="showPassword" id="landing-eye-hide" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 14.805 7.15 18 12 18c1.666 0 3.22-.37 4.593-1.025M6.2 6.2 17.8 17.8m-4.505-8.505a3 3 0 1 1-4.243 4.243M9.878 9.878 6.59 6.59m9.192 9.192 3.288 3.288M12 6c1.666 0 3.22.37 4.593 1.025M22.066 12a10.48 10.48 0 0 0-1.934-3.777" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- TAMPILAN VERIFIKASI KEAMANAN FORM MANUAL (Desain Unik & Jelas) -->
                    <div class="bg-gradient-to-br from-emerald-50/80 via-white to-teal-50/60 p-3.5 rounded-2xl border border-emerald-200/80 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1.5">
                                <span class="text-xs font-bold text-slate-700">Verifikasi Keamanan:</span>
                                <span class="text-[10px] bg-emerald-100 text-emerald-800 font-semibold px-2 py-0.5 rounded-md border border-emerald-200">Wajib</span>
                            </div>
                            <button type="button" @click="generateCaptcha()" class="text-[11px] text-emerald-700 hover:text-emerald-900 font-semibold flex items-center space-x-1 hover:underline">
                                <span>🔄 Ganti Soal</span>
                            </button>
                        </div>
                        
                        <div class="flex items-center space-x-2.5">
                            <div class="w-1/2 bg-emerald-100 text-emerald-900 font-mono font-extrabold px-3 py-2 rounded-xl text-base tracking-wider select-none text-center border border-emerald-300 shadow-sm" 
                                 x-text="num1 + ' + ' + num2 + ' = ?'">
                            </div>
                            <input type="number" 
                                   x-model="captchaInput" 
                                   required 
                                   placeholder="Hasil hitung..." 
                                   class="w-1/2 px-3.5 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs sm:text-sm bg-white font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-normal">
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-600 pt-0.5">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 mr-2"> Ingat saya
                        </label>
                        <button type="button" @click="openForgotPassword()" class="text-emerald-600 hover:text-emerald-700 font-semibold hover:underline">
                            Lupa sandi?
                        </button>
                    </div>

                    <!-- Tombol Masuk Sekarang -->
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-2xl transition shadow-md shadow-emerald-600/25 mt-1 text-xs sm:text-sm">
                        Masuk Sekarang
                    </button>

                    <!-- Pemisah Minimalis "atau" -->
                    <div class="relative flex py-1 items-center">
                        <div class="flex-grow border-t border-slate-200"></div>
                        <span class="flex-shrink mx-3 text-[11px] font-medium text-slate-400">atau</span>
                        <div class="flex-grow border-t border-slate-200"></div>
                    </div>

                    <!-- Tombol Google di Bawah Tombol Login (Minimalis Persis Referensi Desain) -->
                    <button type="button" 
                            @click="openGoogleVerification()" 
                            class="w-full flex items-center justify-center gap-2.5 bg-slate-50 hover:bg-slate-100 text-slate-700 font-medium py-2.5 px-4 rounded-xl border border-slate-200/90 shadow-sm transition-all duration-150 text-xs sm:text-sm group">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span class="group-hover:text-slate-900">Masuk dengan Google</span>
                    </button>
                </form>
            </div>

            {{-- =========================================================================
                 MODE 2: VERIFIKASI KEAMANAN GOOGLE (Bagian manual otomatis tertutup)
            ========================================================================== --}}
            <div x-show="loginMode === 'google'" x-cloak x-transition class="space-y-4">
                <div class="text-center space-y-1">
                    <div class="w-11 h-11 bg-white border border-slate-200 rounded-2xl flex items-center justify-center mx-auto shadow-sm">
                        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800">Verifikasi Keamanan Google</h4>
                    <p class="text-xs text-slate-500">Konfirmasi keamanan sebelum menghubungkan akun Google Anda</p>
                </div>

                <!-- Soal Hitung Cepat Minimalis & Bersih -->
                <div class="bg-slate-50/90 border border-slate-200/90 rounded-2xl p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-600">Hitung Cepat:</span>
                        <button type="button" 
                                @click="generateGoogleCaptcha()" 
                                class="text-xs text-emerald-600 hover:text-emerald-700 font-semibold hover:underline">
                            🔄 Ganti Soal
                        </button>
                    </div>
                    
                    <div class="flex items-center space-x-2.5">
                        <div class="w-1/2 bg-white text-emerald-800 font-mono font-bold text-base px-3 py-2.5 rounded-xl border border-slate-200 text-center shadow-sm select-none"
                             x-text="googleNum1 + ' + ' + googleNum2 + ' = ?'">
                        </div>
                        <input type="number" 
                               x-model="googleCaptchaInput" 
                               @keydown.enter="processGoogleLogin()"
                               placeholder="Jawaban..." 
                               class="w-1/2 px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-bold text-sm bg-white text-slate-900 placeholder:text-slate-400 placeholder:font-normal">
                    </div>
                </div>

                <!-- Status Mengalihkan -->
                <div x-show="googleVerified" x-cloak class="p-2.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl text-center flex items-center justify-center space-x-1.5">
                    <span>✓</span>
                    <span>Verifikasi Berhasil! Mengalihkan ke Google...</span>
                </div>

                <!-- Tombol Aksi Lanjut -->
                <button type="button" 
                        @click="processGoogleLogin()" 
                        :disabled="googleRedirecting"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 disabled:opacity-50 text-white font-bold py-2.5 rounded-xl text-xs sm:text-sm transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2">
                    <span x-show="!googleRedirecting">Lanjutkan ke Google &rarr;</span>
                    <span x-show="googleRedirecting" class="flex items-center space-x-1.5">
                        <span class="animate-spin">⏳</span>
                        <span>Menghubungkan...</span>
                    </span>
                </button>

                <!-- Tombol Batal / Kembali ke Form Manual -->
                <div class="text-center pt-1">
                    <button type="button" 
                            @click="closeGoogleVerification()" 
                            class="text-xs text-slate-500 hover:text-slate-800 font-medium hover:underline inline-flex items-center gap-1">
                        <span>&larr;</span> Kembali ke login NIP / Password
                    </button>
                </div>
            </div>

        </div>

        {{-- =========================================================================
             BAGIAN 3: FORM LUPA SANDI — LANGKAH 1 (INPUT IDENTIFIER & KIRIM OTP)
        ========================================================================== --}}
        <div x-show="authView === 'forgot_request'" x-cloak x-transition class="space-y-4">
            
            <div class="text-center space-y-1">
                <div class="w-12 h-12 bg-amber-50 border border-amber-200 text-amber-600 rounded-2xl flex items-center justify-center mx-auto text-xl shadow-sm">
                    🔑
                </div>
                <h4 class="text-base sm:text-lg font-bold text-slate-900">Pemulihan Kata Sandi</h4>
                <p class="text-xs text-slate-500">
                    Masukkan NIP, Email, atau Username Anda untuk menerima kode OTP verifikasi di Gmail.
                </p>
            </div>

            <!-- Pesan Error / Sukses Lupa Password -->
            <div x-show="forgotError" x-cloak class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl flex items-start space-x-2">
                <span class="text-red-500 font-bold shrink-0">⚠️</span>
                <span x-text="forgotError" class="leading-relaxed"></span>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        NIP / Alamat Gmail / Username Terdaftar <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           x-model="forgotIdentifier" 
                           @keydown.enter="sendForgotOtp()"
                           placeholder="Contoh: 198505122010011001 atau nama@gmail.com" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs sm:text-sm bg-white text-slate-900">
                </div>

                <button type="button" 
                        @click="sendForgotOtp()" 
                        :disabled="forgotLoading"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 text-white font-bold py-2.5 rounded-xl transition shadow-md shadow-emerald-600/20 text-xs sm:text-sm flex items-center justify-center space-x-2">
                    <span x-show="!forgotLoading">Kirim Kode OTP ke Gmail &rarr;</span>
                    <span x-show="forgotLoading" class="flex items-center space-x-1.5">
                        <span class="animate-spin">⏳</span>
                        <span>Mengirimkan OTP...</span>
                    </span>
                </button>

                <div class="pt-2 text-center">
                    <button type="button" 
                            @click="authView = 'login'" 
                            class="text-xs text-slate-500 hover:text-slate-800 font-semibold inline-flex items-center space-x-1">
                        <span>&larr; Kembali ke Halaman Masuk</span>
                    </button>
                </div>
            </div>

        </div>

        {{-- =========================================================================
             BAGIAN 4: FORM LUPA SANDI — LANGKAH 2 (INPUT OTP & KATA SANDI BARU)
        ========================================================================== --}}
        <div x-show="authView === 'forgot_verify'" x-cloak x-transition class="space-y-4">
            
            <div class="text-center space-y-1">
                <div class="w-12 h-12 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto text-xl shadow-sm">
                    ✉️
                </div>
                <h4 class="text-base sm:text-lg font-bold text-slate-900">Verifikasi Kode OTP</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Kode 6 digit telah dikirim ke <span class="font-bold text-emerald-700" x-text="forgotMaskedEmail"></span>. Masukkan kode dan buat kata sandi baru.
                </p>
            </div>

            <!-- Petunjuk Mode Lokal (jika SMTP lokal belum disetel) -->
            <div x-show="forgotDevOtp" x-cloak class="p-2.5 bg-indigo-50 border border-indigo-200 text-indigo-900 text-xs rounded-xl flex items-center justify-between">
                <div>
                    <span class="font-bold">Mode Lokal:</span> Kode OTP Anda adalah:
                    <span class="font-mono font-extrabold text-sm text-indigo-700 ml-1 tracking-wider" x-text="forgotDevOtp"></span>
                </div>
                <button type="button" @click="forgotOtp = forgotDevOtp" class="text-[10px] bg-indigo-600 text-white px-2 py-0.5 rounded font-bold">Isi Otomatis</button>
            </div>

            <!-- Pesan Error / Sukses -->
            <div x-show="forgotError" x-cloak class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl flex items-start space-x-2">
                <span class="text-red-500 font-bold shrink-0">⚠️</span>
                <span x-text="forgotError" class="leading-relaxed"></span>
            </div>

            <div class="space-y-3">
                
                <!-- Kotak Input OTP 6 Digit -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        Masukkan 6 Digit Kode OTP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           x-model="forgotOtp" 
                           maxlength="6"
                           placeholder="Contoh: 123456" 
                           class="w-full text-center tracking-[8px] font-mono font-extrabold text-xl px-4 py-2.5 rounded-xl border-2 border-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-emerald-50/40 text-emerald-950 placeholder:text-slate-300 placeholder:tracking-normal placeholder:font-normal placeholder:text-sm">
                    <p class="text-[10px] text-slate-400 mt-1">Kode berlaku selama 15 menit dari pengiriman.</p>
                </div>

                <!-- Kata Sandi Baru -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        Kata Sandi Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           x-model="forgotPassword" 
                           placeholder="Minimal 6 karakter..." 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs sm:text-sm bg-white text-slate-900">
                </div>

                <!-- Konfirmasi Kata Sandi Baru -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        Ulangi Kata Sandi Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           x-model="forgotPasswordConfirmation" 
                           placeholder="Ketik ulang kata sandi baru..." 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs sm:text-sm bg-white text-slate-900">
                </div>

                <!-- Tombol Submit Simpan Password -->
                <button type="button" 
                        @click="verifyOtpAndReset()" 
                        :disabled="forgotLoading"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 text-white font-bold py-2.5 rounded-xl transition shadow-md shadow-emerald-600/20 text-xs sm:text-sm flex items-center justify-center space-x-2">
                    <span x-show="!forgotLoading">Simpan Kata Sandi Baru</span>
                    <span x-show="forgotLoading" class="flex items-center space-x-1.5">
                        <span class="animate-spin">⏳</span>
                        <span>Menyimpan...</span>
                    </span>
                </button>

                <!-- Tombol Kirim Ulang OTP & Kembali -->
                <div class="flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-100">
                    <button type="button" 
                            @click="sendForgotOtp()" 
                            :disabled="forgotLoading"
                            class="text-emerald-600 hover:text-emerald-700 font-semibold hover:underline">
                        🔄 Kirim Ulang OTP
                    </button>
                    <button type="button" 
                            @click="authView = 'login'" 
                            class="text-slate-500 hover:text-slate-800 font-semibold">
                        Batal
                    </button>
                </div>

            </div>

        </div>

            </div> <!-- Penutup Sisi Kiri (lg:col-span-7) -->

            <!-- SISI KANAN (HERO VISUAL PANEL — PERSIS SEPERTI GAMBAR REFERENSI) -->
            <div class="lg:col-span-5 hidden lg:flex flex-col justify-between relative rounded-[2.2rem] overflow-hidden shadow-xl min-h-[560px] h-full p-6 bg-slate-900 border border-slate-200/50 select-none">
                
                <!-- Background Image: Perbukitan Hijau Segar & Awan Putih Megah -->
                <img src="https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=1200&q=85" 
                     alt="Pemandangan Alam Perbukitan Hijau & Awan Segar" 
                     class="absolute inset-0 w-full h-full object-cover object-center transform hover:scale-105 transition-transform duration-700">
                
                <!-- Overlay Gradasi Halus -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-900/20 to-black/10"></div>

                <!-- Bagian Atas Visual: Badge Glassmorphism -->
                <div class="relative z-10 flex items-center space-x-2 bg-white/20 backdrop-blur-md border border-white/30 text-white px-3.5 py-1.5 rounded-full text-xs font-semibold self-start shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Portal Resmi SIGALA</span>
                </div>

                <!-- Bagian Bawah Visual: Card Info Kaca Elegan -->
                <div class="relative z-10 mt-auto bg-slate-900/50 backdrop-blur-md border border-white/25 rounded-2xl p-4 text-white shadow-xl space-y-1">
                    <div class="text-[10px] font-extrabold tracking-widest text-emerald-300 uppercase">Dinas Pendidikan Kab. Blora</div>
                    <h4 class="font-extrabold text-base leading-snug">Pelayanan Kenaikan Gaji Berkala Digital</h4>
                    <p class="text-xs text-slate-200 leading-relaxed font-normal">Mewujudkan pelayanan kenaikan gaji berkala yang cepat, transparan, dan akurat bagi seluruh GTK.</p>
                </div>

            </div> <!-- Penutup Sisi Kanan (lg:col-span-5) -->

        </div> <!-- Penutup Grid Split View -->

    </div>
</div>

</body>
</html>
