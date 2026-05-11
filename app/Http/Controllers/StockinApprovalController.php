<?php
// app/Http/Controllers/StockInApprovalController.php
namespace App\Http\Controllers;

use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInApprovalController extends Controller
{
    public function index()
    {
        $pendingStockIns = StockIn::with(['product', 'supplier'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('stock_in.approval', compact('pendingStockIns'));
    }

    public function approve(StockIn $stockIn)
    {
        DB::transaction(function () use ($stockIn) {
            $stockIn->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Tambah stock
            $stockIn->product->increment('stock', $stockIn->qty);
        });

        return redirect()->back()->with('success', '✅ Approved!');
    }

    public function reject(StockIn $stockIn)
    {
        $stockIn->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', '❌ Rejected!');
    }
}