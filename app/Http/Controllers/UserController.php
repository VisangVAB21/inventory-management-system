<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 🔒 hanya admin
    private function checkAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->checkAdmin();

        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:3',
        'role' => 'required'
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('users.index')
        ->with('success', 'User berhasil ditambahkan');
}

    public function update(Request $request, $id)
    {
        $this->checkAdmin();

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,manager,staff'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return back()->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        $this->checkAdmin();

        User::findOrFail($id)->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}