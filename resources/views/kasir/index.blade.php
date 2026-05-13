@extends('layouts.app')

@section('content')
<div class="flex gap-6 h-full">
    <!-- Left: Product Grid -->
    <div class="flex-1 min-w-0">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Kasir Pintar</h2>
            <p class="text-sm text-gray-500">Pilih layanan atau produk untuk ditambahkan ke keranjang</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition group border border-gray-100">
                <div class="aspect-square bg-gray-50 relative overflow-hidden p-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain transition duration-300 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i data-lucide="image" class="w-12 h-12"></i>
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-800 mb-1 truncate">{{ $product->name }}</h3>
                    <p class="text-xs text-gray-500 mb-4 line-clamp-2 h-8">{{ $product->description }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-sm font-bold text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-[10px] text-gray-400">/item</span>
                        </div>
                        <button onclick="addToCart({{ json_encode($product) }})" class="w-8 h-8 rounded-full bg-brand-dark text-white flex items-center justify-center hover:bg-brand-light transition transform group-hover:scale-110">
                            <i data-lucide="plus" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Right: Order Summary -->
    <div class="w-80 flex-shrink-0 flex flex-col bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-800 uppercase tracking-widest text-sm">Ringkasan Pesanan</h2>
            <button onclick="clearCart()" class="text-gray-400 hover:text-red-500 transition">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
        </div>

        <div id="cart-items" class="flex-1 overflow-y-auto p-6 space-y-4">
            <!-- Cart items will be injected here by JS -->
            <div class="flex flex-col items-center justify-center h-full text-gray-400 opacity-50">
                <i data-lucide="shopping-cart" class="w-12 h-12 mb-2"></i>
                <p class="text-xs font-medium uppercase tracking-widest">Keranjang Kosong</p>
            </div>
        </div>

        <div class="p-6 bg-gray-50 border-t border-gray-100 space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total</span>
                <span id="cart-total" class="text-xl font-bold text-gray-800">Rp 0</span>
            </div>

            <button id="btn-pay" onclick="showConfirmation()" disabled class="w-full bg-brand-dark hover:bg-brand-light disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-4 rounded-xl transition flex items-center justify-center gap-2">
                <i data-lucide="wallet" class="w-5 h-5"></i>
                <span>Proses Pembayaran</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Pembayaran -->
<div id="modal-confirmation" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full overflow-hidden transform transition-all">
            <div class="p-8 text-center">
                <div class="w-20 h-20 bg-brand-bg rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="help-circle" class="w-10 h-10 text-brand-dark"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Pembayaran</h3>
                <p class="text-gray-500 text-sm mb-8">Apakah anda yakin ingin melakukan pembayaran?</p>
                <div class="flex gap-4">
                    <button onclick="closeConfirmation()" class="flex-1 px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition">
                        Tidak
                    </button>
                    <button onclick="confirmPayment()" class="flex-1 px-6 py-3 rounded-xl bg-brand-dark text-white font-bold hover:bg-brand-light transition">
                        Iyaa
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let cart = [];

    function addToCart(product) {
        const existingItem = cart.find(item => item.id === product.id);
        if (existingItem) {
            existingItem.qty++;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.price),
                qty: 1
            });
        }
        renderCart();
    }

    function removeFromCart(productId) {
        cart = cart.filter(item => item.id !== productId);
        renderCart();
    }

    function updateQty(productId, delta) {
        const item = cart.find(item => item.id === productId);
        if (item) {
            item.qty += delta;
            if (item.qty <= 0) {
                removeFromCart(productId);
            } else {
                renderCart();
            }
        }
    }

    function clearCart() {
        cart = [];
        renderCart();
    }

    function renderCart() {
        const container = document.getElementById('cart-items');
        if (cart.length === 0) {
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full text-gray-400 opacity-50">
                    <i data-lucide="shopping-cart" class="w-12 h-12 mb-2"></i>
                    <p class="text-xs font-medium uppercase tracking-widest">Keranjang Kosong</p>
                </div>
            `;
            document.getElementById('cart-total').innerText = 'Rp 0';
            document.getElementById('btn-pay').disabled = true;
            lucide.createIcons();
            return;
        }

        let total = 0;
        container.innerHTML = cart.map(item => {
            const subtotal = item.price * item.qty;
            total += subtotal;
            return `
                <div class="bg-brand-bg/50 rounded-xl p-4 border border-brand-dark/5">
                    <div class="flex justify-between items-start mb-2">
                        <div class="min-w-0 flex-1">
                            <h4 class="text-xs font-bold text-gray-800 truncate">${item.name}</h4>
                        </div>
                        <span class="text-xs font-bold text-gray-800">Rp ${subtotal.toLocaleString('id-ID')}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 bg-white rounded-lg px-2 py-1 border border-gray-100">
                            <button onclick="updateQty(${item.id}, -1)" class="text-gray-400 hover:text-brand-dark"><i data-lucide="minus" class="w-3 h-3"></i></button>
                            <span class="text-xs font-bold w-4 text-center">${item.qty}</span>
                            <button onclick="updateQty(${item.id}, 1)" class="text-gray-400 hover:text-brand-dark"><i data-lucide="plus" class="w-3 h-3"></i></button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        document.getElementById('cart-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('btn-pay').disabled = false;
        lucide.createIcons();
    }

    function showConfirmation() {
        document.getElementById('modal-confirmation').classList.remove('hidden');
        lucide.createIcons();
    }

    function closeConfirmation() {
        document.getElementById('modal-confirmation').classList.add('hidden');
    }

    async function confirmPayment() {
        closeConfirmation();
        const btnPay = document.getElementById('btn-pay');
        btnPay.disabled = true;
        btnPay.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i><span>Memproses...</span>';
        lucide.createIcons();
        
        await processPayment();
    }

    async function processPayment() {
        const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const paid = total; // Set paid equal to total since we removed manual input

        const response = await fetch("{{ route('kasir.pay') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                items: cart,
                total: total,
                paid: paid
            })
        });

        const result = await response.json();

        if (response.ok) {
            alert('Transaksi Berhasil!');
            clearCart();
            location.reload(); // Refresh to update stocks
        } else {
            alert('Gagal: ' + result.message);
            const btnPay = document.getElementById('btn-pay');
            btnPay.disabled = false;
            btnPay.innerHTML = '<i data-lucide="wallet" class="w-5 h-5"></i><span>Proses Pembayaran</span>';
            lucide.createIcons();
        }
    }
</script>
@endpush
