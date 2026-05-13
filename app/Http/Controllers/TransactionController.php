<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'items'])->latest();
        $statsQuery = Transaction::query();

        if ($request->has('range')) {
            if ($request->range == 'today') {
                $query->whereDate('created_at', Carbon::today());
                $statsQuery->whereDate('created_at', Carbon::today());
            } elseif ($request->range == '7_days') {
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
                $statsQuery->where('created_at', '>=', Carbon::now()->subDays(7));
            } elseif ($request->range == '30_days') {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
                $statsQuery->where('created_at', '>=', Carbon::now()->subDays(30));
            }
        }

        $transactions = $query->paginate(10);
        $totalTransactions = $statsQuery->count();
        $totalRevenue = $statsQuery->sum('total');

        return view('transactions.index', compact(
            'transactions', 
            'totalTransactions', 
            'totalRevenue'
        ));
    }

    public function export()
    {
        $transactions = Transaction::with('items')->get();
        $csvFileName = 'transactions_' . date('Ymd_His') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Tanggal', 'Nama Barang', 'Jumlah', 'Total Amount'];

        $callback = function() use($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transactions as $transaction) {
                foreach ($transaction->items as $item) {
                    fputcsv($file, [
                        $transaction->created_at->format('d M Y, H:i'),
                        $item->product_name,
                        $item->qty,
                        'Rp ' . number_format($item->subtotal, 0, ',', '.')
                    ]);
                }
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
