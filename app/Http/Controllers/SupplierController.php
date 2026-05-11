<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        // ✅ Admin check
        if(auth()->user()->role !== 'admin'){
            abort(403, 'Hanya admin yang bisa menambah supplier!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        // ✅ Fix: Ganti validated() → all()
        Supplier::create($request->all());

        return back()->with('success', '✅ Supplier berhasil ditambahkan');
    }

    public function update(Request $request, Supplier $supplier)
    {
        // ✅ Admin check
        if(auth()->user()->role !== 'admin'){
            abort(403, 'Hanya admin yang bisa edit supplier!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        // ✅ Fix: Ganti validated() → all()
        $supplier->update($request->all());

        return back()->with('success', 'Supplier berhasil diupdate');
    }

    public function destroy(Supplier $supplier)
    {
        // ✅ Admin check
        if(auth()->user()->role !== 'admin'){
            abort(403, 'Hanya admin yang bisa hapus supplier!');
        }

        $supplier->delete();

        return back()->with('success', ' Supplier berhasil dihapus');
    }
}