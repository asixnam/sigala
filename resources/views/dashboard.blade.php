<x-app-layout>
    @php
        $settings = json_decode(@file_get_contents(storage_path('app/settings.json')), true) ?? [
            'welcome_message' => "Dashboard",
            'announcement_title' => "Informasi / Pengumuman Terbaru",
            'announcement' => "You're logged in!",
            'footer_text' => "Status login Anda aktif. Selamat berkegiatan di dalam sistem kepegawaian.",
            'dashboard_theme' => 'light'
        ];
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $settings['welcome_message'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-slate-100 dark:border-slate-800">
                <div class="p-8">
                    <!-- Dynamic Accent Colored Banner -->
                    <div class="p-6 rounded-2xl mb-6 
                        {{ $settings['dashboard_theme'] == 'emerald' ? 'bg-emerald-50 dark:bg-emerald-950/20 text-emerald-800 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-900/30' : '' }}
                        {{ $settings['dashboard_theme'] == 'teal' ? 'bg-teal-50 dark:bg-teal-950/20 text-teal-800 dark:text-teal-300 border border-teal-100 dark:border-teal-900/30' : '' }}
                        {{ $settings['dashboard_theme'] == 'light' ? 'bg-slate-50 dark:bg-slate-900/40 text-slate-800 dark:text-slate-300 border border-slate-100 dark:border-slate-800/40' : '' }}">
                        
                        <div class="flex items-center space-x-3">
                            <span class="text-xl">🔔</span>
                            <span class="font-bold text-sm">{{ $settings['announcement_title'] }}</span>
                        </div>
                        <p class="text-sm mt-3 leading-relaxed whitespace-pre-line">
                            {{ $settings['announcement'] }}
                        </p>
                    </div>

                    <div class="text-slate-700 dark:text-slate-300 text-sm">
                        {{ $settings['footer_text'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
