<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data GTK Sekolah - SIGALA Dinas Pendidikan Kab. Blora</title>
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

        @include('layouts.sekolah-navigation')

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <x-top-header 
                title="Kelola Data GTK Sekolah" 
                titleMobile="Data GTK" 
                :badge="$unitKerja" 
            />

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-4 sm:p-6">
                <x-manage-gtk 
                    :pegawais="$pegawais" 
                    :filterRoute="route('sekolah.gtk')" 
                    :isSekolahRole="true" 
                />
            </main>
        </div>
    </div>

</body>
</html>
