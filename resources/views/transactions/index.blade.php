@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h2>
            <p class="text-sm text-gray-500">Pantau semua aktivitas transaksi yang terjadi di toko.</p>
        </div>
        <a href="{{ route('transactions.export') }}" class="bg-brand-dark hover:bg-brand-light text-white font-bold py-3 px-6 rounded-xl transition flex items-center gap-2">
            <i data-lucide="download" class="w-5 h-5"></i>
            <span>Export CSV</span>
        </a>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Transaksi</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-4xl font-bold text-gray-800">{{ number_format($totalTransactions, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pendapatan</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-4xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex items-center justify-between bg-white/50 p-4 rounded-xl border border-gray-200">
        <form action="{{ route('transactions.index') }}" method="GET" class="flex items-center gap-4">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Rentang Waktu:</span>
            <select name="range" onchange="this.form.submit()" class="bg-white border border-gray-200 rounded-lg px-3 py-1.5 text-xs font-bold focus:ring-2 focus:ring-brand-dark/20">
                <option value="all" {{ request('range') == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                <option value="today" {{ request('range') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="7_days" {{ request('range') == '7_days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="30_days" {{ request('range') == '30_days' ? 'selected' : '' }}>30 Hari Terakhir</option>
            </select>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Barang</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Jumlah</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($transactions as $transaction)
                    @foreach($transaction->items as $index => $item)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 text-xs text-gray-500">
                            {{ $index === 0 ? $transaction->created_at->translatedFormat('d M Y, H:i') : '' }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800 text-sm">{{ $item->product_name }}</td>
                        <td class="px-6 py-4 text-center text-sm font-bold">{{ $item->qty }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        
        <div class="p-6 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">Menampilkan {{ $transactions->firstItem() ?? 0 }}-{{ $transactions->lastItem() ?? 0 }} dari {{ $transactions->total() }} transaksi</p>
            {{ $transactions->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
