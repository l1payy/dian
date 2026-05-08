<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->where('stock', '>', 0)->get();
        return view('kasir.index', compact('products'));
    }

    public function pay(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'paid' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        if ($request->paid < $request->total) {
            return response()->json(['message' => 'Pembayaran kurang.'], 422);
        }

        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'total' => $request->total,
                'paid' => $request->paid,
                'change' => $request->paid - $request->total,
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);
                
                if ($product->stock < $item['qty']) {
                    throw new \Exception("Stok {$product->name} tidak cukup.");
                }

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'qty' => $item['qty'],
                    'subtotal' => $product->price * $item['qty'],
                ]);

                $product->decrement('stock', $item['qty']);
            }

            DB::commit();

            return response()->json([
                'message' => 'Transaksi berhasil.',
                'transaction_id' => $transaction->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
