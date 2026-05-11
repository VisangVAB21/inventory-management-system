<x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Laporan</h1>
    </div>

    <!-- FILTER -->
    <form method="GET" action="/reports"
        class="bg-slate-800 rounded-xl p-4 mb-6 flex flex-wrap gap-4 items-end shadow">

        <!-- Jenis Laporan -->
        <div class="flex flex-col gap-1">
            <label class="text-gray-400 text-xs uppercase">Jenis Laporan</label>
            <select name="type"
                class="px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="stock"     {{ $type == 'stock'     ? 'selected' : '' }}>Stok Saat Ini</option>
                <option value="stock_in"  {{ $type == 'stock_in'  ? 'selected' : '' }}>Barang Masuk</option>
                <option value="stock_out" {{ $type == 'stock_out' ? 'selected' : '' }}>Barang Keluar</option>
                <option value="low_stock" {{ $type == 'low_stock' ? 'selected' : '' }}>Stok Menipis</option>
                <option value="recap"     {{ $type == 'recap'     ? 'selected' : '' }}>Rekap</option>
            </select>
        </div>

        <!-- Tanggal Dari -->
        <div class="flex flex-col gap-1">
            <label class="text-gray-400 text-xs uppercase">Dari Tanggal</label>
            <input type="date" name="date_from" value="{{ $dateFrom }}"
                class="px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Tanggal Sampai -->
        <div class="flex flex-col gap-1">
            <label class="text-gray-400 text-xs uppercase">Sampai Tanggal</label>
            <input type="date" name="date_to" value="{{ $dateTo }}"
                class="px-3 py-2 rounded-lg bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Tombol Filter -->
        <button type="submit"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
            Tampilkan
        </button>

        <!-- Tombol Export -->
        @if($type != 'recap')
        <a href="/reports/export/pdf?type={{ $type }}&date_from={{ $dateFrom }}&date_to={{ $dateTo }}"
            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold">
            Export PDF
        </a>
        @endif

    </form>

    <!-- REKAP CARDS -->
    @if($type == 'recap')
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-slate-800 rounded-xl p-4 shadow text-center">
            <p class="text-gray-400 text-xs uppercase mb-1">Total Barang Masuk</p>
            <p class="text-2xl font-bold text-green-400">{{ $data['total_stock_in'] }}</p>
            <p class="text-gray-500 text-xs">unit</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-4 shadow text-center">
            <p class="text-gray-400 text-xs uppercase mb-1">Total Barang Keluar</p>
            <p class="text-2xl font-bold text-orange-400">{{ $data['total_stock_out'] }}</p>
            <p class="text-gray-500 text-xs">unit</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-4 shadow text-center">
            <p class="text-gray-400 text-xs uppercase mb-1">Total Produk</p>
            <p class="text-2xl font-bold text-blue-400">{{ $data['total_produk'] }}</p>
            <p class="text-gray-500 text-xs">produk</p>
        </div>
        <div class="bg-slate-800 rounded-xl p-4 shadow text-center">
            <p class="text-gray-400 text-xs uppercase mb-1">Stok Menipis</p>
            <p class="text-2xl font-bold text-red-400">{{ $data['low_stock'] }}</p>
            <p class="text-gray-500 text-xs">produk</p>
        </div>
    </div>

    <!-- TABEL LAPORAN -->
    @else
    <div class="bg-slate-800 rounded-xl shadow-lg overflow-hidden">
        <table class="w-full text-sm text-left text-gray-300">
            <thead class="bg-slate-700 text-gray-200 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">No</th>

                    @if($type == 'stock')
                        <th class="px-6 py-3">Nama Produk</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Merk</th>
                        <th class="px-6 py-3">Warna</th>
                        <th class="px-6 py-3">Ukuran</th>
                        <th class="px-6 py-3">Stok</th>
                        <th class="px-6 py-3">Harga</th>

                    @elseif($type == 'stock_in')
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Supplier</th>
                        <th class="px-6 py-3">Qty</th>
                        <th class="px-6 py-3">Catatan</th>

                    @elseif($type == 'stock_out')
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Qty</th>

                    @elseif($type == 'low_stock')
                        <th class="px-6 py-3">Nama Produk</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Stok</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse($data as $index => $row)
                <tr class="hover:bg-slate-700 transition">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>

                    @if($type == 'stock')
                        <td class="px-6 py-4 font-semibold text-white">{{ $row->name }}</td>
                        <td class="px-6 py-4">{{ $row->category->name ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $row->merk   ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $row->warna  ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $row->ukuran ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($row->stock <= 10)
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-400">
                                    {{ $row->stock }}
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-400">
                                    {{ $row->stock }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">Rp {{ number_format($row->price) }}</td>

                    @elseif($type == 'stock_in')
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-semibold text-white">{{ $row->product->name  ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $row->supplier->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-green-400 font-semibold">+{{ $row->qty }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $row->note ?? '-' }}</td>

                    @elseif($type == 'stock_out')
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-semibold text-white">{{ $row->product->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-orange-400 font-semibold">-{{ $row->qty }}</td>

                    @elseif($type == 'low_stock')
                        <td class="px-6 py-4 font-semibold text-white">{{ $row->name }}</td>
                        <td class="px-6 py-4">{{ $row->category->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-400">
                                {{ $row->stock }}
                            </span>
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

</div>
</x-app-layout>