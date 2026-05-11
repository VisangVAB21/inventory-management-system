<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\ActivityLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today();

        if ($user->role === 'admin') {
            $data = [
                'total_produk'    => Product::count(),
                'total_stock_in'  => StockIn::count(),
                'total_stock_out' => StockOut::count(),
                'low_stock'       => Product::where('stock', '<=', 10)->count(),
                'chart_labels'    => Product::with('category')->get()->pluck('name'),
                'chart_data'      => Product::get()->pluck('stock'),
                'recent_activity' => ActivityLog::with('user')->latest()->take(10)->get(),
            ];
        } elseif ($user->role === 'manager') {
            $data = [
                'low_stock_products' => Product::with('category')->where('stock', '<=', 10)->get(),
                'stock_in_today'     => StockIn::with(['product', 'supplier'])->whereDate('date', $today)->get(),
                'stock_out_today'    => StockOut::with('product')->whereDate('date', $today)->get(),
                'total_masuk_hari'   => StockIn::whereDate('date', $today)->sum('qty'),
                'total_keluar_hari'  => StockOut::whereDate('date', $today)->sum('qty'),
            ];
        } elseif ($user->role === 'staff') {
            $data = [
                'stock_in_pending'  => StockIn::with(['product', 'supplier'])->whereDate('date', $today) ->where('status', 'pending')->latest()->get(),
                'stock_out_pending' => StockOut::with('product')->whereDate('date', $today) ->where('status', 'pending')->latest()->get(),
            ];
        } else {
            $data = [];
        }
        

        return view('dashboard', compact('data'));
    }
    
}