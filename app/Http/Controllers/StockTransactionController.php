<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;

class StockTransactionController extends Controller
{

    // ✅ TAMBAHAN: HISTORY TRANSAKSI
    public function index(Request $request)
    {
        // 🔒 ROLE CHECK
        if (!in_array(auth()->user()->role, ['admin','manager','staff'])) {
            abort(403);
        }

        $query = StockTransaction::with('product')->latest();

        // 🔍 filter produk
        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        // 📅 filter tanggal
       if ($request->start_date && $request->end_date) {
            $query->whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date);
            }

        $transactions = $query->get();
        $products = Product::all();

        return view('transactions.index', compact('transactions','products'));
    }
}