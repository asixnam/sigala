<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard Sekolah - SIGALA Dinas Pendidikan Kab. Blora' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logoblora.png') }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Navigation Sekolah -->
        @include('layouts.sekolah-navigation')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Header -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-10 shadow-sm">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = true" class="lg:hidden text-slate-600 hover:text-slate-900 focus:outline-none">
                        ☰
                    </button>
                    <h1 class="text-lg font-bold text-slate-800">{{ $headerTitle ?? 'Dashboard Satuan Pendidikan (Sekolah)' }}</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-xs bg-emerald-100 text-emerald-700 font-semibold px-3 py-1 rounded-full">
                        Kabupaten Blora
                    </span>
                </div>
            </header>

            <!-- Scrollable Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6">
                {{ $slot ?? '' }}
                @yield('content')
            </main>

        </div>

    </div>

</body>
</html>
