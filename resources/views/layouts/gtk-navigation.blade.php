<!-- Navigation / Sidebar GTK -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto flex flex-col border-r border-slate-800 shadow-xl">
    
    <!-- Sidebar Header & User Info -->
    <div class="p-4 bg-slate-900 border-b border-slate-800">
        <!-- <div class="flex items-center justify-between mb-3 px-2">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('img/logoblora.png') }}" alt="Logo" class="h-8 w-auto object-contain">
                <span class="font-bold text-white text-sm tracking-wide uppercase">SIGALA GTK</span>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white focus:outline-none">✕</button>
        </div> -->

        <!-- User Info Mini -->
        <div class="flex items-center space-x-3 px-4 py-3 rounded-2xl bg-slate-950/40 border border-slate-800/80">
            @if(optional(auth()->user()->pegawai)->foto_profil && file_exists(public_path(auth()->user()->pegawai->foto_profil)))
                <img src="{{ asset(auth()->user()->pegawai->foto_profil) }}" alt="Profil" class="w-9 h-9 rounded-full object-cover border border-slate-700 shrink-0">
            @else
                <div class="w-9 h-9 rounded-full bg-emerald-600/20 text-emerald-400 flex items-center justify-center font-bold text-xs shrink-0">
                    GTK
                </div>
            @endif
            <div class="overflow-hidden">
                <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->pegawai->nama ?? (auth()->user()->nama ?? 'Pegawai GTK') }}</p>
                <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->nip_pegawai ? 'NIP. '.auth()->user()->nip_pegawai : (auth()->user()->email ?? 'gtk@blorakab.go.id') }}</p>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu Links -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto text-sm font-medium">
        <!-- 1. Dashboard Saya -->
        <a href="{{ route('gtk.dashboard') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('gtk.dashboard') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Dashboard Saya</span>
        </a>

        <!-- 2. Data Usulan KGB -->
        <a href="{{ route('gtk.usulan') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('gtk.usulan*') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Data Usulan KGB</span>
        </a>

        <!-- 3. Profil & Data Pegawai -->
        <a href="{{ route('gtk.profil') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('gtk.profil*') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Profil & Data Pegawai</span>
        </a>
    </nav>

    <hr class="border-slate-800 mx-4">

    <!-- Sidebar Footer / Bottom Actions -->
    <div class="p-4 bg-slate-900">

        <!-- Portal Publik -->
        <a href="/" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200 group text-sm font-semibold mb-2">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Portal Publik</span>
        </a>

        <!-- Log Out -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <input type="hidden" name="guard" value="gtk">
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-2xl text-red-400 hover:bg-red-500/10 transition-all duration-200 text-sm font-semibold">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</aside>
