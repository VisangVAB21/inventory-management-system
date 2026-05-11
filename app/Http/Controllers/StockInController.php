<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function index()
    {
        $stockIns = StockIn::with(['product', 'supplier'])->latest()->get();
        $products = Product::all();
        $suppliers = Supplier::all();

        return view('stock_in.index', compact('stockIns', 'products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'  => 'required',
            'supplier_id' => 'required',
            'qty'         => 'required|integer|min:1',
            'date'        => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            StockIn::create([
                'product_id'  => $request->product_id,
                'supplier_id' => $request->supplier_id,
                'qty'         => $request->qty,
                'date'        => $request->date,
                'note'        => $request->note,
            ]);

            $product = Product::findOrFail($request->product_id);
            $product->increment('stock', $request->qty);

            StockTransaction::create([
                'product_id' => $request->product_id,
                'type'       => 'in',
                'quantity'   => $request->qty,
                'created_at' => $request->date,
            ]);

            // ✅ Activity log stock in
            activity_log(
                'Stock In',
                'Barang masuk: ' . $product->name . ' sejumlah ' . $request->qty . ' unit'
            );

            DB::commit();

            return redirect()->route('stock_in.index')
                ->with('success', 'Barang masuk berhasil dicatat');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('stock_in.index')
                ->with('error', 'Gagal mencatat barang masuk: ' . $e->getMessage());
        }
    }

    public function checkStockIn($id)
{
    $stockIn = StockIn::findOrFail($id);
    $stockIn->update(['status' => 'checked']);

    activity_log('Cek Barang Masuk', 'Staff mengecek barang masuk: ' . $stockIn->product->name . ' sejumlah ' . $stockIn->qty . ' unit');

    return response()->json(['message' => 'Barang berhasil dicek'], 200);
}
}