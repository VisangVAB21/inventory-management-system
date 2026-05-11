<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1e293b; }
        h2 { text-align: center; margin-bottom: 4px; }
        p.subtitle { text-align: center; color: #64748b; margin-bottom: 16px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background-color: #1e3a5f; color: white; }
        th, td { padding: 8px 12px; border: 1px solid #e2e8f0; text-align: left; }
        tbody tr:nth-child(even) { background-color: #f8fafc; }
        .badge-red { color: #dc2626; font-weight: bold; }
        .badge-green { color: #16a34a; font-weight: bold; }
        .badge-orange { color: #ea580c; font-weight: bold; }
    </style>
</head>
<body>

    <h2>
        @if($type == 'stock') Laporan Stok Saat Ini
        @elseif($type == 'stock_in') Laporan Barang Masuk
        @elseif($type == 'stock_out') Laporan Barang Keluar
        @elseif($type == 'low_stock') Laporan Stok Menipis
        @endif
    </h2>
    <p class="subtitle">Periode: {{ $dateFrom }} s/d {{ $dateTo }} &nbsp;|&nbsp; Dicetak: {{ now()->format('d M Y, H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                @if($type == 'stock')
                    <th>Nama Produk</th><th>Kategori</th><th>Merk</th><th>Warna</th><th>Ukuran</th><th>Stok</th><th>Harga</th>
                @elseif($type == 'stock_in')
                    <th>Tanggal</th><th>Produk</th><th>Supplier</th><th>Qty</th><th>Catatan</th>
                @elseif($type == 'stock_out')
                    <th>Tanggal</th><th>Produk</th><th>Qty</th>
                @elseif($type == 'low_stock')
                    <th>Nama Produk</th><th>Kategori</th><th>Stok</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                @if($type == 'stock')
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->category->name ?? '-' }}</td>
                    <td>{{ $row->merk   ?? '-' }}</td>
                    <td>{{ $row->warna  ?? '-' }}</td>
                    <td>{{ $row->ukuran ?? '-' }}</td>
                    <td class="{{ $row->stock <= 10 ? 'badge-red' : 'badge-green' }}">{{ $row->stock }}</td>
                    <td>Rp {{ number_format($row->price) }}</td>
                @elseif($type == 'stock_in')
                    <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                    <td>{{ $row->product->name  ?? '-' }}</td>
                    <td>{{ $row->supplier->name ?? '-' }}</td>
                    <td class="badge-green">+{{ $row->qty }}</td>
                    <td>{{ $row->note ?? '-' }}</td>
                @elseif($type == 'stock_out')
                    <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                    <td>{{ $row->product->name ?? '-' }}</td>
                    <td class="badge-orange">-{{ $row->qty }}</td>
                @elseif($type == 'low_stock')
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->category->name ?? '-' }}</td>
                    <td class="badge-red">{{ $row->stock }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>