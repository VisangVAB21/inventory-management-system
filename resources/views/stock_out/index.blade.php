<x-app-layout>

<div class="max-w-6xl mx-auto p-6 text-white">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Barang Keluar</h1>
        {{-- Blade Template --}}
        @if(auth()->user()->role === 'staff')
        <button onclick="openModal()"
            class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-medium">
            + Barang Keluar
        </button>
        @endif
    </div>

    <!-- TABLE -->
    <div class="bg-slate-800 rounded-xl overflow-hidden shadow">

        <table class="w-full text-sm text-left">
            <thead class="bg-slate-700 text-gray-200">
                <tr>
                    <th class="p-4">Produk</th>
                    <th class="p-4">Qty</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Catatan</th>
                </tr>
            </thead>

            <tbody>
                @foreach($stockOuts as $s)
                <tr class="border-b border-slate-700 hover:bg-slate-750">
                    <td class="p-4">{{ $s->product->name }}</td>
                    <td class="p-4">{{ $s->qty }}</td>
                    <td class="p-4">{{ $s->date }}</td>
                    <td class="p-4">{{ $s->note ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>


<!-- MODAL -->
<div id="modal" class="fixed inset-0 hidden bg-black/60 flex items-center justify-center">

    <div class="bg-slate-800 w-full max-w-md rounded-xl p-6 shadow-lg">

        <h2 class="text-lg font-semibold mb-4">Tambah Barang Keluar</h2>

        <form action="{{ route('stock_out.store') }}" method="POST" class="space-y-3">
            @csrf

            <select name="product_id"
                class="w-full p-2 rounded bg-slate-700 text-white">
                @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>

            <input type="number" name="qty" placeholder="Qty"
                class="w-full p-2 rounded bg-slate-700 text-white">

            <input type="date" name="date"
                class="w-full p-2 rounded bg-slate-700 text-white">

            <textarea name="note" placeholder="Catatan"
                class="w-full p-2 rounded bg-slate-700 text-white"></textarea>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-gray-600 rounded">
                    Batal
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-red-600 rounded">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

<script>
function openModal(){
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal(){
    document.getElementById('modal').classList.add('hidden');
}
</script>

</x-app-layout>