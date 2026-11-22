<header 
    x-data="{ scrolled: window.scrollY > 20, mobileMenuOpen: false }" 
    @scroll.window="scrolled = (window.scrollY > 20)"
    :class="scrolled ? 'bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm' : 'bg-transparent border-transparent'"
    class="fixed top-0 left-0 right-0 z-40 transition-all duration-300">
    <div :class="scrolled ? 'h-14 sm:h-16' : 'h-16 sm:h-20'" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between transition-all duration-300">
        
        <!-- Logo Group -->
        <a href="#home" class="flex items-center space-x-2 sm:space-x-3 shrink-0">
            <img src="{{ asset('img/logoblora.png') }}" alt="Logo Blora" class="h-6 sm:h-8 w-auto object-contain"> 
            <div :class="scrolled ? 'bg-slate-200/80' : 'bg-white/20'" class="h-5 sm:h-6 w-px transition-colors duration-300"></div>
            <img src="{{ asset('img/dindik.png') }}" alt="Logo DINDIK" 
                 :class="scrolled ? 'brightness-0' : 'brightness-0 invert'" 
                 class="h-6 sm:h-8 w-auto object-contain transition-all duration-300">
        </a>

        <!-- Desktop Navigation Links -->
        <nav :class="scrolled ? 'text-slate-600' : 'text-white/90'" class="hidden md:flex items-center space-x-6 lg:space-x-8 text-sm font-semibold tracking-wide transition-colors duration-300">
            <a href="#home" :class="scrolled ? 'hover:text-[#065366]' : 'hover:text-white'" class="transition-colors duration-200">Beranda</a>
            <a href="#fitur" :class="scrolled ? 'hover:text-[#065366]' : 'hover:text-white'" class="transition-colors duration-200">Fitur Utama</a>
            <a href="#alur" :class="scrolled ? 'hover:text-[#065366]' : 'hover:text-white'" class="transition-colors duration-200">Alur Layanan</a>
            <a href="#kontak" :class="scrolled ? 'hover:text-[#065366]' : 'hover:text-white'" class="transition-colors duration-200">Kontak</a>
        </nav>

        <!-- Right Side Actions (Login Button & Mobile Hamburger Toggle) -->
        <div class="flex items-center space-x-2 sm:space-x-3">
            @php
                $hasActiveSession = \Illuminate\Support\Facades\Auth::check();
            @endphp
            
            <button @click="openLogin = true" 
                    :class="scrolled ? 'bg-[#00a854] hover:bg-[#008d47] text-white shadow-md hover:shadow-lg' : 'bg-white hover:bg-slate-100 text-[#065366] shadow-md hover:shadow-lg'"
                    class="text-xs sm:text-sm font-bold px-4 py-2 sm:px-6 sm:py-2.5 rounded-xl hover:-translate-y-0.5 transition-all duration-300 inline-flex items-center gap-1.5 sm:gap-2 shrink-0">
                <span>Login</span>
            </button>

            <!-- Mobile Hamburger Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    :class="scrolled ? 'text-slate-700 hover:text-slate-900 bg-slate-100' : 'text-white hover:text-slate-100 bg-white/10 backdrop-blur-md'"
                    class="md:hidden p-2 rounded-xl focus:outline-none transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Drawer / Dropdown -->
    <div x-show="mobileMenuOpen" 
         @click.away="mobileMenuOpen = false" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-3"
         class="md:hidden bg-white/95 backdrop-blur-md border-b border-slate-200 px-4 pt-2 pb-5 space-y-2 shadow-xl" 
         style="display: none;">
        <a href="#home" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-100 hover:text-emerald-700 transition">Beranda</a>
        <a href="#fitur" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-100 hover:text-emerald-700 transition">Fitur Utama</a>
        <a href="#alur" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-100 hover:text-emerald-700 transition">Alur Layanan</a>
        <a href="#kontak" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-100 hover:text-emerald-700 transition">Kontak</a>
    </div>
</header>
