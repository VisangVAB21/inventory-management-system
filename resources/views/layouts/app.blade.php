<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
function activeMenu($patterns) {
    foreach((array)$patterns as $pattern){
        if(request()->is($pattern)) return 'bg-blue-600 text-white';
    }
    return 'text-gray-300 hover:bg-slate-700';
}
@endphp
<!-- SWEETALERT CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif
@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session('error') }}'
});
</script>
@endif
@if ($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    html: `{!! implode('<br>', $errors->all()) !!}`
});
</script>
@endif
<body class="bg-slate-900 text-white">
<div class="flex h-screen">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-slate-800 p-5 hidden md:block">
        <!-- Logo -->
        <div class="flex items-center space-x-3 mb-8">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-boxes-stacked text-white"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg">Stockify</h1>
                <p class="text-xs text-gray-400">Sistem Manajemen</p>
            </div>
        </div>
        <!-- Menu -->
        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-2 rounded transition
               {{ request()->is('dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-slate-700 text-gray-300' }}">
                <i class="fa-solid fa-house mr-3"></i> Dashboard
            </a>
            <a href="{{ route('products.index') }}"
               class="flex items-center px-4 py-2 rounded {{ activeMenu('products*') }}">
                <i class="fa-solid fa-box mr-3"></i> Produk
            </a>
            <a href="{{ route('categories.index') }}"
               class="flex items-center px-4 py-2 rounded transition
               {{ request()->is('categories*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-700 text-gray-300' }}">
                <i class="fa-solid fa-tags mr-3"></i> Kategori
            </a>
            @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}"
                   class="flex items-center px-4 py-2 rounded {{ activeMenu('users*') }}">
                    <i class="fa-solid fa-users mr-3"></i> Kelola User
                </a>
            @endif
            @endauth
             @auth
            @if(in_array(auth()->user()->role, ['admin','manager']))
                <a href="{{ route('reports.index') }}"
                class="flex items-center px-4 py-2 rounded {{ activeMenu('reports*') }}">
                    <i class="fa-solid fa-chart-line mr-3"></i> Laporan
                </a>
                <a href="{{ route('activity.index') }}"
                class="flex items-center px-4 py-2 rounded {{ activeMenu('activity*') }}">
                    <i class="fa-solid fa-clock-rotate-left mr-3"></i>
                    Activity Log
                </a>
            @endif
            @endauth
            <a href="{{ route('suppliers.index') }}"
               class="flex items-center px-4 py-2 rounded {{ activeMenu('suppliers*') }}">
                <i class="fa-solid fa-truck mr-3"></i> Supplier
            </a>
            <a href="{{ route('stock_in.index') }}"
               class="flex items-center px-4 py-2 rounded {{ activeMenu('stock_in*') }}">
                <i class="fa-solid fa-arrow-down mr-3"></i> Barang Masuk
            </a>
            <a href="{{ route('stock_out.index') }}"
               class="flex items-center px-4 py-2 rounded {{ activeMenu('stock_out*') }}">
                <i class="fa-solid fa-arrow-up mr-3"></i> Barang Keluar
            </a>
            @auth
            @if(in_array(auth()->user()->role, ['admin','manager','staff']))
                <a href="{{ url('/transactions') }}"
                   class="flex items-center px-4 py-2 rounded {{ activeMenu('transactions*') }}">
                    <i class="fa-solid fa-right-left mr-3"></i> History Transaksi
                </a>
            @endif
            @endauth

            <!-- MENU SETTINGS DITAMBAHKAN -->
            @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.settings') }}"
                   class="flex items-center px-4 py-2 rounded transition {{ activeMenu(['admin/settings*', 'settings*']) }}">
                    <i class="fa-solid fa-cog mr-3"></i> Pengaturan
                </a>
            @endif
            @endauth

        </nav>
    </aside>
    <!-- MAIN -->
<div class="flex-1 flex flex-col min-w-0">
            <!-- TOPBAR -->
        <header class="bg-slate-800 px-6 py-4 flex justify-between items-center border-b border-slate-700">
            <h2 class="text-xl font-semibold">Dashboard</h2>
            <div class="flex items-center space-x-4">
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-500 px-3 py-1 rounded">
                        Logout
                    </button>
                </form>
            </div>
        </header>
        <!-- CONTENT -->
        <main class="p-6 overflow-y-auto overflow-x-hidden">            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>
    </div>
</div>
</body>
@stack('scripts')
</html>