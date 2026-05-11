<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $type;
    protected $dateFrom;
    protected $dateTo;

    public function __construct($type, $dateFrom, $dateTo)
    {
        $this->type     = $type;
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
    }

    public function collection()
    {
        return match($this->type) {

            'stock' => Product::with('category')->get()->map(fn($p) => [
                'Nama Produk' => $p->name,
                'Kategori'    => $p->category->name ?? '-',
                'Merk'        => $p->merk   ?? '-',
                'Warna'       => $p->warna  ?? '-',
                'Ukuran'      => $p->ukuran ?? '-',
                'Stok'        => $p->stock,
                'Harga'       => $p->price,
            ]),

            'stock_in' => StockIn::with(['product', 'supplier'])
                ->whereBetween('date', [$this->dateFrom, $this->dateTo])
                ->latest()->get()->map(fn($s) => [
                    'Tanggal'  => $s->date,
                    'Produk'   => $s->product->name  ?? '-',
                    'Supplier' => $s->supplier->name ?? '-',
                    'Qty'      => $s->qty,
                    'Catatan'  => $s->note ?? '-',
                ]),

            'stock_out' => StockOut::with('product')
                ->whereBetween('date', [$this->dateFrom, $this->dateTo])
                ->latest()->get()->map(fn($s) => [
                    'Tanggal' => $s->date,
                    'Produk'  => $s->product->name ?? '-',
                    'Qty'     => $s->qty,
                ]),

            'low_stock' => Product::with('category')
                ->where('stock', '<=', 10)->get()->map(fn($p) => [
                    'Nama Produk' => $p->name,
                    'Kategori'    => $p->category->name ?? '-',
                    'Stok'        => $p->stock,
                ]),

            default => collect()
        };
    }

    public function headings(): array
    {
        return match($this->type) {
            'stock'     => ['Nama Produk', 'Kategori', 'Merk', 'Warna', 'Ukuran', 'Stok', 'Harga'],
            'stock_in'  => ['Tanggal', 'Produk', 'Supplier', 'Qty', 'Catatan'],
            'stock_out' => ['Tanggal', 'Produk', 'Qty'],
            'low_stock' => ['Nama Produk', 'Kategori', 'Stok'],
            default     => []
        };
    }

    public function title(): string
    {
        return match($this->type) {
            'stock'     => 'Laporan Stok',
            'stock_in'  => 'Laporan Barang Masuk',
            'stock_out' => 'Laporan Barang Keluar',
            'low_stock' => 'Stok Menipis',
            default     => 'Laporan'
        };
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'color' => ['rgb' => '1e3a5f']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}