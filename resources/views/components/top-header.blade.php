@props([
    'title' => 'Dashboard',
    'titleMobile' => null,
    'badge' => null,
    'badgeClass' => 'bg-emerald-100 text-emerald-800 border border-emerald-200/60',
])

<header class="h-14 sm:h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 z-10 shadow-sm gap-2">
    <div class="flex items-center space-x-2.5 min-w-0">
        <button @click="sidebarOpen = true" class="lg:hidden text-slate-600 hover:text-slate-900 focus:outline-none p-1 shrink-0">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <h1 class="text-sm sm:text-base md:text-lg font-bold text-slate-800 truncate">
            @if($titleMobile)
                <span class="inline sm:hidden">{{ $titleMobile }}</span>
                <span class="hidden sm:inline">{{ $title }}</span>
            @else
                <span>{{ $title }}</span>
            @endif
        </h1>
    </div>

    <div class="flex items-center space-x-2 shrink-0">
        @if(isset($slot) && trim($slot))
            {{ $slot }}
        @endif

        @if($badge)
            <span class="text-[11px] sm:text-xs font-semibold px-2.5 sm:px-3 py-1 rounded-full truncate max-w-[130px] sm:max-w-none {{ $badgeClass }}">
                {{ $badge }}
            </span>
        @endif
    </div>
</header>
