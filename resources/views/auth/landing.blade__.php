<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGALA - Sistem Informasi Kenaikan Gaji Berkala Dinas Pendidikan Kab. Blora</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans">

    <!-- Header / Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-600 text-white font-bold p-2 rounded-lg text-lg">SG</div>
                <div>
                    <h1 class="text-xl font-bold text-blue-900 leading-tight">SIGALA</h1>
                    <p class="text-xs text-slate-500">Dinas Pendidikan Kabupaten Blora</p>
                </div>
            </div>
            <div>
                <a href="#login" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition shadow-sm">
                    Masuk Aplikasi
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section / Landing Content -->
    <section class="max-w-7xl mx-auto px-4 py-16 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div>
            <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Layanan Kepegawaian Digital</span>
            <h2 class="text-4xl font-extrabold text-slate-900 mt-4 leading-tight">
                Pengajuan Kenaikan Gaji Berkala (KGB) Lebih Cepat & Transparan
            </h2>
            <p class="mt-4 text-slate-600 leading-relaxed">
                SIGALA hadir untuk memudahkan GTK (Guru dan Tenaga Kependidikan) di lingkungan Dinas Pendidikan Kabupaten Blora dalam memproses usulan KGB secara elektronik terintegrasi dengan validasi SIMPEG dan Tanda Tangan Elektronik (TTE).
            </p>
            <div class="mt-8 flex space-x-4">
                <a href="#login" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition">
                    Mulai Masuk
                </a>
                <a href="#kontak" class="border border-slate-300 hover:bg-slate-100 font-medium px-6 py-3 rounded-lg transition text-slate-700">
                    Hubungi Dinas
                </a>
            </div>
        </div>
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-slate-100" id="login">
            <h3 class="text-2xl font-bold text-slate-900 mb-2">Masuk ke Akun</h3>
            <p class="text-sm text-slate-500 mb-6">Masukkan NIP dan kata sandi Anda untuk mengakses layanan.</p>

            @if($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 text-sm text-red-700 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.authenticate') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">NIP / Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Masukkan NIP Anda">
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Kata Sandi (Password)</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition shadow">
                    Masuk Sistem
                </button>
            </form>
        </div>
    </section>

    <!-- Kontak Dinas Section -->
    <section id="kontak" class="bg-white border-t border-slate-200 py-16 mt-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold text-slate-900 mb-2">Dinas Pendidikan Kabupaten Blora</h3>
            <p class="text-slate-600 max-w-xl mx-auto mb-8">Pusat Layanan Terpadu Administrasi Kepegawaian Guru dan Tenaga Kependidikan.</p>
            <div class="text-sm text-slate-600 space-y-2">
                <p>📍 Alamat: Jl. Dr. Soetomo No. 42, Blora, Jawa Tengah</p>
                <p>📧 Email: diknas@blorakab.go.id | ☎️ Telepon: (0296) 5311xx</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-6 text-center text-xs">
        <p>&copy; 2026 SIGALA - Dinas Pendidikan Kabupaten Blora. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>
