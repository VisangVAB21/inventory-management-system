<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use Illuminate\Support\Collection;

class ReportController extends Controller
{
    // ================= DATA HELPER =================
    private function getReportData($type, $dateFrom, $dateTo): Collection|array
    {
        $dateFrom = Carbon::parse($dateFrom)->startOfDay();
        $dateTo = Carbon::parse($dateTo)->endOfDay();

        return match($type) {
            'stock' => Product::with('category')->get(),

            'stock_in' => StockIn::with(['product', 'supplier'])
                ->whereBetween('date', [$dateFrom, $dateTo])
                ->latest()
                ->get(),

            'stock_out' => StockOut::with('product')
                ->whereBetween('date', [$dateFrom, $dateTo])
                ->latest()
                ->get(),

            'low_stock' => Product::with('category')
                ->where('stock', '<=', 10)
                ->get(),

            'recap' => collect([
                'total_stock_in'  => StockIn::whereBetween('date', [$dateFrom, $dateTo])->sum('qty'),
                'total_stock_out' => StockOut::whereBetween('date', [$dateFrom, $dateTo])->sum('qty'),
                'total_produk'    => Product::count(),
                'low_stock'       => Product::where('stock', '<=', 10)->count(),
            ]),

            default => collect()
        };
    }

    // ================= INDEX =================
    public function index(Request $request)
    {
        $type = $request->get('type', 'stock');
        $dateFrom = $request->get('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->get('date_to', now()->toDateString());

        // Validasi tanggal
        try {
            $dateFrom = Carbon::parse($dateFrom)->toDateString();
            $dateTo = Carbon::parse($dateTo)->toDateString();
        } catch (\Exception $e) {
            $dateFrom = now()->startOfMonth()->toDateString();
            $dateTo = now()->toDateString();
        }

        $data = $this->getReportData($type, $dateFrom, $dateTo);

        return view('reports.index', compact('data', 'type', 'dateFrom', 'dateTo'));
    }

    // ================= EXPORT PDF =================
    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'stock');
        $dateFrom = $request->get('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->get('date_to', now()->toDateString());

        // Validasi tanggal
        try {
            $dateFrom = Carbon::parse($dateFrom)->toDateString();
            $dateTo = Carbon::parse($dateTo)->toDateString();
        } catch (\Exception $e) {
            $dateFrom = now()->startOfMonth()->toDateString();
            $dateTo = now()->toDateString();
        }

        $data = $this->getReportData($type, $dateFrom, $dateTo);

        $pdf = Pdf::loadView('reports.pdf', compact('data', 'type', 'dateFrom', 'dateTo'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        $filename = 'laporan-' . $type . '-' . now()->format('Ymd-His') . '.pdf';

        return $pdf->download($filename);
    }

    // ================= EXPORT EXCEL =================
    public function exportExcel(Request $request)
    {
        $type = $request->get('type', 'stock');
        $dateFrom = $request->get('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->get('date_to', now()->toDateString());

        // Validasi tanggal
        try {
            $dateFrom = Carbon::parse($dateFrom)->toDateString();
            $dateTo = Carbon::parse($dateTo)->toDateString();
        } catch (\Exception $e) {
            $dateFrom = now()->startOfMonth()->toDateString();
            $dateTo = now()->toDateString();
        }

        $filename = 'laporan-' . $type . '-' . now()->format('Ymd-His') . '.xlsx';

        try {
            return Excel::download(new ReportExport($type, $dateFrom, $dateTo), $filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal export Excel: ' . $e->getMessage());
        }
    }
}