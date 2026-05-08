@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Pengaturan Sistem</h2>
            <p class="text-sm text-gray-500">Konfigurasi operasional dan profil unit bisnis.</p>
        </div>
        <button onclick="document.getElementById('form-settings').submit()" class="bg-brand-dark hover:bg-brand-light text-white font-bold py-3 px-6 rounded-xl transition flex items-center gap-2">
            <i data-lucide="save" class="w-5 h-5"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>

    <!-- Admin Profile Card -->
    <div class="bg-brand-dark rounded-2xl p-8 shadow-lg text-white relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <div class="w-24 h-24 rounded-2xl bg-white/10 border-2 border-white/20 p-1">
                <div class="w-full h-full rounded-xl bg-white/20 flex items-center justify-center">
                    <i data-lucide="user" class="w-12 h-12 text-white/50"></i>
                </div>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h3 class="text-2xl font-bold mb-1">{{ Auth::user()->name }}</h3>
                <span class="inline-block px-3 py-1 bg-white/10 rounded-full text-[10px] font-bold uppercase tracking-widest border border-white/20 mb-4">
                    {{ Auth::user()->role == 'admin' ? 'ADMINISTRATOR SISTEM' : 'STAF KASIR' }}
                </span>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                    <div class="flex items-center gap-2 px-4 py-2 bg-black/20 rounded-xl border border-white/5">
                        <i data-lucide="mail" class="w-4 h-4 text-white/50"></i>
                        <span class="text-xs">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-black/20 rounded-xl border border-white/5">
                        <i data-lucide="shield-check" class="w-4 h-4 text-white/50"></i>
                        <span class="text-xs">Izin Akses: Penuh</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <button onclick="toggleModal('modal-password')" class="w-full px-6 py-2 bg-white/10 hover:bg-white/20 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-white/10 transition flex items-center justify-center gap-2">
                    <i data-lucide="key" class="w-3 h-3"></i>
                    Ganti Kata Sandi
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-6 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-red-500/20 transition flex items-center justify-center gap-2">
                        <i data-lucide="log-out" class="w-3 h-3"></i>
                        Keluar Sesi
                    </button>
                </form>
            </div>
        </div>
        <!-- Background Decor -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-16 -mb-16"></div>
    </div>

    <!-- Store Information -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-10 h-10 rounded-xl bg-brand-bg flex items-center justify-center text-brand-dark">
                <i data-lucide="store" class="w-5 h-5"></i>
            </div>
            <h3 class="font-bold text-gray-800 uppercase tracking-widest text-sm">Informasi Toko</h3>
        </div>

        <form id="form-settings" action="{{ route('settings.update') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @csrf
            <div class="space-y-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Toko</label>
                <input type="text" name="store_name" value="{{ $settings['store_name'] ?? 'Foto Copy Prima Diski' }}" class="w-full px-6 py-3 bg-brand-bg border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-dark/20">
            </div>
            <div class="space-y-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nomor Telepon</label>
                <input type="text" name="store_phone" value="{{ $settings['store_phone'] ?? '+62 812-3456-7890' }}" class="w-full px-6 py-3 bg-brand-bg border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-dark/20">
            </div>
            <div class="md:col-span-2 space-y-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Alamat Lengkap</label>
                <textarea name="store_address" rows="3" class="w-full px-6 py-4 bg-brand-bg border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-dark/20">{{ $settings['store_address'] ?? 'Jl. Raya Pendidikan No. 45, Kecamatan Sukamaju, Kota Jakarta Selatan, 12345' }}</textarea>
            </div>
        </form>
    </div>
</div>

<!-- Password Modal -->
<div id="modal-password" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-6 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-800 uppercase tracking-widest text-sm">Ganti Kata Sandi</h3>
            <button onclick="toggleModal('modal-password')" class="text-gray-400 hover:text-gray-600"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form action="{{ route('settings.password') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="space-y-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Password Saat Ini</label>
                <input type="password" name="current_password" required class="w-full px-4 py-2 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20">
            </div>
            <div class="space-y-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Password Baru</label>
                <input type="password" name="new_password" required class="w-full px-4 py-2 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20">
            </div>
            <div class="space-y-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" required class="w-full px-4 py-2 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20">
            </div>
            <button type="submit" class="w-full bg-brand-dark hover:bg-brand-light text-white font-bold py-3 rounded-xl transition">Ganti Password</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }
</script>
@endpush
