<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin','staff'])) {
            abort(403);
        }

        $request->validate([
            'name' => 'required'
        ]);

        Category::create($request->all());

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        if (!in_array(auth()->user()->role, ['admin','staff'])) {
            abort(403);
        }

        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        Category::findOrFail($id)->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}
