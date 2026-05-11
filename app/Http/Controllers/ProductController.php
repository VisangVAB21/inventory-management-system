<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'buy_price'     => 'required|numeric|min:0',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|numeric|min:0',
            'initial_stock' => 'required|numeric|min:0',
            'category_id'   => 'required|exists:categories,id',
            'merk'          => 'nullable|string|max:100',
            'warna'         => 'nullable|string|max:100',
            'ukuran'        => 'nullable|string|max:50',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only([
            'name', 'description', 'buy_price', 'price', 'stock',
            'initial_stock', 'category_id', 'merk', 'warna', 'ukuran'
        ]);

        // Upload Gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        activity_log('Tambah Produk', 'Menambahkan produk: ' . $product->name);

        return response()->json(['message' => 'Produk berhasil ditambahkan'], 201);
    }

    public function update(Request $request, $id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $product = Product::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'buy_price'     => 'required|numeric|min:0',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|numeric|min:0',
            'initial_stock' => 'required|numeric|min:0',
            'category_id'   => 'required|exists:categories,id',
            'merk'          => 'nullable|string|max:100',
            'warna'         => 'nullable|string|max:100',
            'ukuran'        => 'nullable|string|max:50',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only([
            'name', 'description', 'buy_price', 'price', 'stock',
            'initial_stock', 'category_id', 'merk', 'warna', 'ukuran'
        ]);

        // Upload Gambar Baru + Hapus Gambar Lama
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        activity_log('Update Produk', 'Mengupdate produk: ' . $product->name);

        return response()->json(['message' => 'Produk berhasil diperbarui'], 200);
    }
    
    public function edit($id)
{
    $product = Product::findOrFail($id);
    
    return response()->json([
        'id'            => $product->id,
        'name'          => $product->name,
        'description'   => $product->description,
        'buy_price'     => $product->buy_price,
        'price'         => $product->price,
        'stock'         => $product->stock,
        'initial_stock' => $product->initial_stock,
        'category_id'   => $product->category_id,
        'merk'          => $product->merk,
        'warna'         => $product->warna,
        'ukuran'        => $product->ukuran,
        'image'         => $product->image,
        'image_url'     => $product->image ? asset('storage/' . $product->image) : null,
    ]);
}

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $product = Product::findOrFail($id);

        // Hapus gambar jika ada
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $namaProduct = $product->name;
        $product->delete();

        activity_log('Hapus Produk', 'Menghapus produk: ' . $namaProduct);

        return response()->json(['message' => 'Produk berhasil dihapus'], 200);
    }


public function opname(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $stokSistem = $product->stock;
    $stokFisik = (int) $request->stok_fisik;
    $selisih = $stokFisik - $stokSistem;

    // Update stok ke hasil fisik
    $product->stock = $stokFisik;
    $product->save();

    // Simpan log opname (optional tapi disarankan)
    DB::table('stock_opnames')->insert([
        'product_id' => $id,
        'stok_sistem' => $stokSistem,
        'stok_fisik' => $stokFisik,
        'selisih' => $selisih,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return response()->json([
        'success' => true
    ]);
}
}
