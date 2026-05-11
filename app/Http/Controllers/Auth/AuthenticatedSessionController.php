<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends Controller
{
    // TAMPILKAN HALAMAN LOGIN
    public function create(): View
    {
        return view('auth.login');
    }

    // PROSES LOGIN
  public function store(LoginRequest $request)
{
    $request->authenticate();

    $request->session()->regenerate();

    return redirect('/dashboard'); // 🔥 WAJIB ADA INI
}

    // LOGOUT
    public function destroy(): RedirectResponse
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}