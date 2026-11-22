<!-- Navigation / Sidebar Admin -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto flex flex-col border-r border-slate-800 shadow-xl">
    
    <!-- Sidebar Header -->
    <div class="h-20 flex items-center justify-between px-6 bg-slate-900">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('img/logoblora.png') }}" alt="Logo" class="h-9 w-auto object-contain">
            <span class="font-bold text-white text-base tracking-wide uppercase">SIGALA ADMIN</span>
        </div>
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1 focus:outline-none">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    
    <hr class="border-slate-800 mx-4">

    <!-- Sidebar Menu Links -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto text-sm font-medium">
        <!-- 1. Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- 2. Usulan KGB & TTE -->
        <a href="{{ route('admin.usulan') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.usulan') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Usulan KGB & TTE</span>
        </a>

        <!-- 4. Data GTK / Pegawai -->
        <a href="{{ route('admin.gtk') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.gtk') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Data GTK / Pegawai</span>
        </a>

        <!-- 5. Daftar Sekolah -->
        <a href="{{ route('admin.sekolah') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.sekolah') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
            </svg>
            <span>Daftar Sekolah</span>
        </a>

        <!-- 6. Pengaturan -->
        <a href="{{ route('admin.settings') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.settings') ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Pengaturan</span>
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
            <input type="hidden" name="guard" value="superadmin">
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-2xl text-red-400 hover:bg-red-500/10 transition-all duration-200 text-sm font-semibold">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</aside>
