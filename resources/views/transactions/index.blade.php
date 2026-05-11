<x-app-layout>

<div class="p-6">

    <h1 class="text-2xl font-bold text-white mb-6">History Transaksi</h1>

    <!-- FILTER -->
    <form method="GET" class="flex gap-3 mb-6">
        

        <select name="product_id" class="p-2 bg-slate-700 text-white">
            <option value="">Semua Produk</option>
            @foreach($products as $p)
            <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
        </select>

        <input type="date" name="start_date" class="p-2 bg-slate-700 text-white">
        <input type="date" name="end_date" class="p-2 bg-slate-700 text-white">

        <button class="bg-blue-600 px-4 text-white rounded">Filter</button>

    </form>

    <!-- TABLE -->
    <div class="bg-slate-800 rounded-xl overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-700 text-white">
                <tr>
                    <th class="px-4 py-2">Produk</th>
                    <th class="px-4 py-2">Tipe</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                <tr class="border-b border-slate-600">
                    <td class="px-4 py-2">{{ $t->product->name }}</td>

                    <td class="px-4 py-2">
                        @if($t->type == 'in')
                            <span class="text-green-400">Masuk</span>
                        @else
                            <span class="text-red-400">Keluar</span>
                        @endif
                    </td>

                    <td class="px-4 py-2">{{ $t->quantity }}</td>
                    <td class="px-4 py-2">{{ $t->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

</x-app-layout>