<!-- Navigation / Sidebar Sekolah -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto flex flex-col border-r border-slate-800 shadow-xl">
    
    <!-- Sidebar Header & User Info -->
    <div class="p-4 bg-slate-900 border-b border-slate-800">
        <!-- User Info Mini -->
        <div class="flex items-center space-x-3 px-4 py-3 rounded-2xl bg-slate-950/40 border border-slate-800/80">
            @if(auth()->user()->logo_sekolah && file_exists(public_path(auth()->user()->logo_sekolah)))
                <img src="{{ asset(auth()->user()->logo_sekolah) }}" alt="Logo Sekolah" class="w-9 h-9 rounded-full object-cover border border-slate-700 shrink-0">
            @else
                <div class="w-9 h-9 rounded-full bg-emerald-600/20 text-emerald-400 flex items-center justify-center font-bold text-xs shrink-0">
                    SCH
                </div>
            @endif
            <div class="overflow-hidden">
                <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->unit_kerja ?? 'Operator Sekolah' }}</p>
                <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email ?? 'sekolah@sigala.test' }}</p>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu Links -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto text-sm font-medium">
        <!-- 1. Dashboard Sekolah -->
        <a href="{{ route('sekolah.dashboard') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('sekolah.dashboard') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Dashboard Sekolah</span>
        </a>

        <!-- 2. Usulan KGB & TTE -->
        <a href="{{ route('sekolah.usulan') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('sekolah.usulan*') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Usulan KGB & TTE</span>
        </a>

        <!-- 3. Data Guru & GTK -->
        <a href="{{ route('sekolah.gtk') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('sekolah.gtk*') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span>Data Guru & GTK</span>
        </a>

        <!-- 4. Profil Sekolah -->
        <a href="{{ route('sekolah.profil') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('sekolah.profil*') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H7" />
            </svg>
            <span>Profil Sekolah</span>
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
            <input type="hidden" name="guard" value="admin_sekolah">
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-2xl text-red-400 hover:bg-red-500/10 transition-all duration-200 text-sm font-semibold">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</aside>
