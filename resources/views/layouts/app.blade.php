<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Prima - Sistem Kasir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-brand-bg font-sans text-gray-800">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-40 bg-brand-dark flex-shrink-0 flex flex-col">
            <div class="p-4 mb-4">
                <h1 class="text-white font-bold text-lg leading-tight">Toko Prima</h1>
                <p class="text-white text-[10px] opacity-70">Website Sistem Kasir</p>
            </div>
            
            <nav class="flex-1 px-2 space-y-1">
                <a href="{{ route('kasir.index') }}" class="flex flex-col items-center p-3 text-white rounded-lg transition {{ request()->routeIs('kasir.index') ? 'bg-brand-active' : 'hover:bg-brand-light' }}">
                    <i data-lucide="layout-grid" class="w-6 h-6 mb-1"></i>
                    <span class="text-xs">Beranda</span>
                </a>
                <a href="{{ route('transactions.index') }}" class="flex flex-col items-center p-3 text-white rounded-lg transition {{ request()->routeIs('transactions.index') ? 'bg-brand-active' : 'hover:bg-brand-light' }}">
                    <i data-lucide="file-text" class="w-6 h-6 mb-1"></i>
                    <span class="text-xs text-center">Riwayat Transaksi</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex flex-col items-center p-3 text-white rounded-lg transition {{ request()->routeIs('products.index') ? 'bg-brand-active' : 'hover:bg-brand-light' }}">
                    <i data-lucide="package" class="w-6 h-6 mb-1"></i>
                    <span class="text-xs text-center">Stok Barang</span>
                </a>
                <a href="{{ route('settings.index') }}" class="flex flex-col items-center p-3 text-white rounded-lg transition {{ request()->routeIs('settings.index') ? 'bg-brand-active' : 'hover:bg-brand-light' }}">
                    <i data-lucide="settings" class="w-6 h-6 mb-1"></i>
                    <span class="text-xs text-center">Pengaturan</span>
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white text-xs">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-white text-[10px] font-bold truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-white/60 text-[8px] truncate">{{ Auth::user()->role ?? 'Kasir' }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 text-white/70 hover:text-white transition text-xs">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar -->
            <header class="bg-white/50 backdrop-blur-sm px-6 py-4 flex items-center justify-between border-b border-gray-200">
                <div class="flex-1 max-w-md">
                    <form action="{{ url()->current() }}" method="GET" class="relative">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari layanan atau produk..." class="w-full pl-10 pr-4 py-2 bg-brand-bg border-none rounded-full text-sm focus:ring-2 focus:ring-brand-dark/20">
                    </form>
                </div>
                
                <div class="flex items-center gap-4 ml-4">
                    <div class="flex items-center gap-2 pl-4 border-l border-gray-200">
                        <div class="w-8 h-8 rounded-full bg-brand-dark flex items-center justify-center text-white">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        <span class="text-sm font-medium">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
