@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Stock Barang</h2>
            <p class="text-sm text-gray-500">Atur katalog produk, harga, dan ketersediaan stok fisik.</p>
        </div>
        <button onclick="toggleModal('modal-add')" class="bg-brand-dark hover:bg-brand-light text-white font-bold py-3 px-6 rounded-xl transition flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            <span>Tambah Barang Baru</span>
        </button>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Barang</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
                <i data-lucide="package" class="w-6 h-6"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Barang Hampir Habis</p>
                <h3 class="text-3xl font-bold text-red-600">{{ $lowStockProducts }}</h3>
            </div>
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-600">
                <i data-lucide="alert-triangle" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Gambar</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Produk</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Stok</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Harga</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($products as $product)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden border border-gray-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <i data-lucide="image" class="w-5 h-5"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $product->name }}</td>
                    <td class="px-6 py-4">
                        <span class="{{ $product->stock <= 5 ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <button onclick="editProduct({{ json_encode($product) }})" class="text-green-600 hover:text-green-800 flex items-center gap-1 text-xs font-bold">
                                <i data-lucide="edit-3" class="w-3 h-3"></i> Edit
                            </button>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 flex items-center gap-1 text-xs font-bold">
                                    <i data-lucide="trash-2" class="w-3 h-3"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div id="modal-add" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-6 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-800 uppercase tracking-widest text-sm">Tambah Barang Baru</h3>
            <button onclick="toggleModal('modal-add')" class="text-gray-400 hover:text-gray-600"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Produk</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Stok</label>
                    <input type="number" name="stock" required class="w-full px-4 py-2 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Harga</label>
                    <input type="number" name="price" required class="w-full px-4 py-2 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Gambar</label>
                    <input type="file" name="image" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-brand-dark file:text-white hover:file:bg-brand-light">
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20"></textarea>
                </div>
            </div>
            <button type="submit" class="w-full bg-brand-dark hover:bg-brand-light text-white font-bold py-3 rounded-xl transition">Simpan Produk</button>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="modal-edit" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-6 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-800 uppercase tracking-widest text-sm">Edit Produk</h3>
            <button onclick="toggleModal('modal-edit')" class="text-gray-400 hover:text-gray-600"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form id="form-edit" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Produk</label>
                    <input type="text" name="name" id="edit-name" required class="w-full px-4 py-2 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Stok</label>
                    <input type="number" name="stock" id="edit-stock" required class="w-full px-4 py-2 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Harga</label>
                    <input type="number" name="price" id="edit-price" required class="w-full px-4 py-2 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Gambar (Kosongkan jika tidak diubah)</label>
                    <input type="file" name="image" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-brand-dark file:text-white hover:file:bg-brand-light">
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Deskripsi</label>
                    <textarea name="description" id="edit-description" rows="3" class="w-full px-4 py-2 bg-brand-bg border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-dark/20"></textarea>
                </div>
            </div>
            <button type="submit" class="w-full bg-brand-dark hover:bg-brand-light text-white font-bold py-3 rounded-xl transition">Perbarui Produk</button>
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

    function editProduct(product) {
        const form = document.getElementById('form-edit');
        form.action = `/products/${product.id}`;
        
        document.getElementById('edit-name').value = product.name;
        document.getElementById('edit-stock').value = product.stock;
        document.getElementById('edit-price').value = parseInt(product.price);
        document.getElementById('edit-description').value = product.description;

        toggleModal('modal-edit');
    }
</script>
@endpush
