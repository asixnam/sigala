<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koneksi Google Sign-In - SIGALA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-6">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="w-16 h-16 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center justify-center mx-auto shadow-sm">
                <!-- Google Icon SVG -->
                <svg class="w-8 h-8" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
            </div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Google OAuth Sign-In SIGALA</h2>
            <p class="text-xs sm:text-sm text-slate-500">Pemberitahuan Konfigurasi Google Cloud</p>
        </div>

        <!-- Info Card -->
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-xs text-amber-900 space-y-2">
            <div class="font-bold flex items-center space-x-2 text-amber-800 text-sm">
                <span>⚠️ Google Client ID Belum Dikonfigurasi di .env</span>
            </div>
            <p class="leading-relaxed">
                Untuk menghubungkan ke Google secara langsung di server produksi, Anda cukup menambahkan 2 baris berikut pada file <code class="bg-white px-2 py-0.5 rounded font-mono border border-amber-200">.env</code> Anda:
            </p>
            <div class="bg-slate-900 text-emerald-400 p-3 rounded-xl font-mono text-[11px] overflow-x-auto select-all">
            GOOGLE_CLIENT_ID=isi-client-id-anda.apps.googleusercontent.com<br>
            GOOGLE_CLIENT_SECRET=isi-client-secret-anda
            </div>
        </div>

        <!-- Direct Test Mode: Pilih Akun Gmail Terdaftar -->
        <div class="space-y-3">
            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center justify-between">
                <span>Uji Langsung Akun Gmail Terdaftar:</span>
                <span class="text-[10px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 font-semibold">Mode Cepat 1-Klik</span>
            </h3>
            <p class="text-xs text-slate-500">
                Pilih salah satu akun terdaftar di bawah ini untuk langsung masuk tanpa mengetik password:
            </p>

            <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                @forelse($registeredUsers as $u)
                    <form action="{{ route('auth.google.direct') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="email" value="{{ $u->email }}">
                        <button type="submit" class="w-full flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50/50 transition text-left group">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-100 group-hover:bg-emerald-100 flex items-center justify-center font-bold text-slate-700 group-hover:text-emerald-700 text-xs">
                                    {{ strtoupper(substr($u->username ?? $u->email, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 group-hover:text-emerald-700">{{ $u->email }}</div>
                                    <div class="text-[10px] text-slate-500 font-mono">Role: {{ strtoupper($u->role) }} &bull; {{ $u->username }}</div>
                                </div>
                            </div>
                            <span class="text-xs font-semibold text-emerald-600 group-hover:translate-x-1 transition">Masuk &rarr;</span>
                        </button>
                    </form>
                @empty
                    <div class="text-center p-4 text-xs text-slate-400 italic">Belum ada akun pengguna dengan email.</div>
                @endforelse
            </div>
        </div>

        <!-- Footer -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
            <a href="{{ route('login') }}" class="text-slate-500 hover:text-slate-800 font-semibold flex items-center space-x-1">
                <span>&larr; Kembali ke Login</span>
            </a>
            <span class="text-slate-400 font-mono text-[11px]">SIGALA Authentication</span>
        </div>

    </div>

</body>
</html>

