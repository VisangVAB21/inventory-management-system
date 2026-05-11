<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransaction;

class StockConfirmationController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::with(['product', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('stock.confirmations', compact('transactions'));
    }

    public function confirm(Request $request, $id)
    {
        $transaction = StockTransaction::findOrFail($id);

        if (!in_array(auth()->user()->role, ['staff', 'manager', 'admin'])) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes'  => 'nullable|string|max:500'
        ]);

        $transaction->update([
            'status'       => $request->status,
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
            'notes'        => $request->notes,
        ]);

        // Update stok produk jika disetujui
        if ($request->status === 'approved') {
            $product = $transaction->product;
            if ($transaction->type === 'in') {
                $product->increment('stock', $transaction->quantity);
            } else {
                $product->decrement('stock', $transaction->quantity);
            }
        }

        activity_log(
            $request->status === 'approved' ? 'Konfirmasi Transaksi' : 'Tolak Transaksi',
            auth()->user()->name . ' ' . ($request->status === 'approved' ? 'menyetujui' : 'menolak') . ' ' . $transaction->quantity . ' ' . $transaction->product->name
        );

        return response()->json(['message' => 'Transaksi berhasil dikonfirmasi']);
    }
}