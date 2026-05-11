<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
{
    public function index()
    {
        $stockOuts = StockOut::with('product')->latest()->get();
        $products = Product::all();

        return view('stock_out.index', compact('stockOuts', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty'        => 'required|integer|min:1',
            'date'       => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($request->product_id);

            if ($product->stock < $request->qty) {
                return redirect()->route('stock_out.index')
                    ->with('error', 'Stok tidak cukup');
            }

            StockOut::create([
                'product_id' => $request->product_id,
                'qty'        => $request->qty,
                'date'       => $request->date,
            ]);

            $product->decrement('stock', $request->qty);

            StockTransaction::create([
                'product_id' => $request->product_id,
                'type'       => 'out',
                'quantity'   => $request->qty,
                'created_at' => $request->date,
            ]);

            // ✅ Activity log stock out
            activity_log(
                'Stock Out',
                'Barang keluar: ' . $product->name . ' sejumlah ' . $request->qty . ' unit'
            );

            DB::commit();

            return redirect()->route('stock_out.index')
                ->with('success', 'Barang keluar berhasil dicatat');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('stock_out.index')
                ->with('error', 'Gagal mencatat barang keluar: ' . $e->getMessage());
        }
    }
    public function prepareStockOut($id)
{
    $stockOut = StockOut::findOrFail($id);
    $stockOut->update(['status' => 'prepared']);

    activity_log('Siapkan Barang Keluar', 'Staff menyiapkan barang keluar: ' . $stockOut->product->name . ' sejumlah ' . $stockOut->qty . ' unit');

    return response()->json(['message' => 'Barang berhasil disiapkan'], 200);
}
}