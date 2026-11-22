<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Usulan KGB Saya - GTK SIGALA</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logoblora.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        @include('layouts.gtk-navigation')

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <x-top-header 
                title="Riwayat & Status Usulan KGB Saya" 
                titleMobile="Usulan KGB Saya" 
                :badge="$pegawai->unit_kerja ?? 'GTK'" 
            />

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-4 sm:p-6">
                <x-manage-usulan    
                    :usulans="$usulans" 
                    :pegawai="$pegawai" 
                    :latestUsulan="$latestUsulan ?? null" 
                    :filterRoute="route('gtk.usulan')" 
                    :isGtkRole="true" 
                />
            </main>
        </div>
    </div>

</body>
</html>
