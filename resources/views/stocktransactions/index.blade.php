<div class="bg-slate-800 p-4 rounded-xl mb-6">
<form action="/stock" method="POST" class="flex gap-3 items-center">
    @csrf

    <select name="product_id" class="bg-slate-700 text-white p-2 rounded">
       @foreach($transactions as $t)
    <tr>
    <td>{{ $t->product->name }}</td>
    <td>{{ $t->type }}</td>
    <td>{{ $t->quantity }}</td>
    <td>{{ $t->created_at }}</td>
    </tr>
    @endforeach
    </select>

    <select name="type" class="bg-slate-700 text-white p-2 rounded">
        <option value="in">Masuk</option>
        <option value="out">Keluar</option>
    </select>

    <input type="number" name="quantity" placeholder="Qty"
        class="bg-slate-700 text-white p-2 rounded">

    <button class="bg-blue-500 px-4 rounded">Simpan</button>
</form>

</div>