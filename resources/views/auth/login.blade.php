<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Prima Diski</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-bg h-screen flex flex-col items-center justify-center p-6">
    <div class="mb-8 text-center">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-10">
        <div class="text-center mb-10">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Sistem Kasir Toko Prima</h1>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Email</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email anda" class="w-full pl-10 pr-4 py-3 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                </div>
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kata Sandi</label>
                </div>
                <div class="relative">
                    <input type="password" name="password" required placeholder="••••••••" class="w-full pl-10 pr-12 py-3 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </div>
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-brand-dark hover:bg-brand-light text-white font-bold py-4 rounded-xl transition flex items-center justify-center gap-2 group">
                <span>Masuk</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
        </form>

        <p class="mt-10 text-center text-[10px] text-gray-400 leading-relaxed uppercase tracking-tighter">
            Akses dibatasi hanya untuk staf berwenang Prima Diski.
        </p>
    </div>

    <footer class="mt-12 text-[10px] text-gray-400 uppercase tracking-widest">
        © 2026 Toko Prima Copyright All Rights Reserved.
    </footer>
</body>
</html>
