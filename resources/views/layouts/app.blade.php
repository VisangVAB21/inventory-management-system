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
    <!-- SIDEBAR -->
<aside class="w-64 bg-slate-800 flex-col hidden md:flex h-screen sticky top-0">

    <!-- Logo -->
    <div class="flex items-center space-x-3 p-5 border-b border-slate-700">
        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-boxes-stacked text-white"></i>
        </div>
        <div>
            <h1 class="font-bold text-lg text-white">Stockify</h1>
            <p class="text-xs text-gray-400">Sistem Manajemen</p>
        </div>
    </div>

    <!-- Menu -->
    <nav class="flex-1 overflow-y-auto p-4 space-y-1">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-3 py-2.5 rounded-lg transition-all text-sm font-medium
           {{ request()->is('dashboard') ? 'bg-blue-600 text-white shadow' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
            <i class="fa-solid fa-house w-5 mr-3 text-center"></i>
            Dashboard
        </a>

        <!-- ===== MASTER DATA ===== -->
        @php $masterActive = request()->is('products*') || request()->is('categories*') || request()->is('suppliers*'); @endphp
        <div>
            <button onclick="toggleMenu('master')"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-all text-sm font-medium
                {{ $masterActive ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <span class="flex items-center">
                    <i class="fa-solid fa-database w-5 mr-3 text-center text-purple-400"></i>
                    Master Data
                </span>
                <i id="icon-master" class="fa-solid fa-chevron-down text-xs transition-transform duration-300
                   {{ $masterActive ? 'rotate-180' : '' }}"></i>
            </button>

            <div id="menu-master"
                 class="overflow-hidden transition-all duration-300 ease-in-out
                 {{ $masterActive ? 'max-h-40 opacity-100' : 'max-h-0 opacity-0' }}">
                <div class="mt-1 ml-4 pl-3 border-l border-slate-600 space-y-1 py-1">

                    <a href="{{ route('products.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg transition-all text-sm
                       {{ request()->is('products*') ? 'bg-blue-600/20 text-blue-400 font-semibold' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                        <i class="fa-solid fa-box w-5 mr-3 text-center"></i> Produk
                    </a>

                    <a href="{{ route('categories.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg transition-all text-sm
                       {{ request()->is('categories*') ? 'bg-blue-600/20 text-blue-400 font-semibold' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                        <i class="fa-solid fa-tags w-5 mr-3 text-center"></i> Kategori
                    </a>

                    <a href="{{ route('suppliers.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg transition-all text-sm
                       {{ request()->is('suppliers*') ? 'bg-blue-600/20 text-blue-400 font-semibold' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                        <i class="fa-solid fa-truck w-5 mr-3 text-center"></i> Supplier
                    </a>

                </div>
            </div>
        </div>

        <!-- ===== TRANSAKSI ===== -->
        @php $transaksiActive = request()->is('stock_in*') || request()->is('stock_out*') || request()->is('transactions*'); @endphp
        <div>
            <button onclick="toggleMenu('transaksi')"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-all text-sm font-medium
                {{ $transaksiActive ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <span class="flex items-center">
                    <i class="fa-solid fa-arrow-right-arrow-left w-5 mr-3 text-center text-green-400"></i>
                    Transaksi
                </span>
                <i id="icon-transaksi" class="fa-solid fa-chevron-down text-xs transition-transform duration-300
                   {{ $transaksiActive ? 'rotate-180' : '' }}"></i>
            </button>

            <div id="menu-transaksi"
                 class="overflow-hidden transition-all duration-300 ease-in-out
                 {{ $transaksiActive ? 'max-h-40 opacity-100' : 'max-h-0 opacity-0' }}">
                <div class="mt-1 ml-4 pl-3 border-l border-slate-600 space-y-1 py-1">

                    <a href="{{ route('stock_in.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg transition-all text-sm
                       {{ request()->is('stock_in*') ? 'bg-blue-600/20 text-blue-400 font-semibold' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                        <i class="fa-solid fa-arrow-down w-5 mr-3 text-center text-green-400"></i> Barang Masuk
                    </a>

                    <a href="{{ route('stock_out.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg transition-all text-sm
                       {{ request()->is('stock_out*') ? 'bg-blue-600/20 text-blue-400 font-semibold' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                        <i class="fa-solid fa-arrow-up w-5 mr-3 text-center text-orange-400"></i> Barang Keluar
                    </a>

                    @if(in_array(auth()->user()->role, ['admin','manager','staff']))
                    <a href="{{ url('/transactions') }}"
                       class="flex items-center px-3 py-2 rounded-lg transition-all text-sm
                       {{ request()->is('transactions*') ? 'bg-blue-600/20 text-blue-400 font-semibold' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                        <i class="fa-solid fa-clock-rotate-left w-5 mr-3 text-center text-cyan-400"></i> History Transaksi
                    </a>
                    @endif

                </div>
            </div>
        </div>

        <!-- ===== LAPORAN ===== -->
        @if(in_array(auth()->user()->role, ['admin','manager']))
        @php $laporanActive = request()->is('reports*'); @endphp
        <div>
            <button onclick="toggleMenu('laporan')"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-all text-sm font-medium
                {{ $laporanActive ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <span class="flex items-center">
                    <i class="fa-solid fa-chart-line w-5 mr-3 text-center text-yellow-400"></i>
                    Laporan
                </span>
                <i id="icon-laporan" class="fa-solid fa-chevron-down text-xs transition-transform duration-300
                   {{ $laporanActive ? 'rotate-180' : '' }}"></i>
            </button>

            <div id="menu-laporan"
                 class="overflow-hidden transition-all duration-300 ease-in-out
                 {{ $laporanActive ? 'max-h-20 opacity-100' : 'max-h-0 opacity-0' }}">
                <div class="mt-1 ml-4 pl-3 border-l border-slate-600 space-y-1 py-1">

                    <a href="{{ route('reports.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg transition-all text-sm
                       {{ request()->is('reports*') ? 'bg-blue-600/20 text-blue-400 font-semibold' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                        <i class="fa-solid fa-file-lines w-5 mr-3 text-center"></i> Semua Laporan
                    </a>

                </div>
            </div>
        </div>
        @endif

        <!-- ===== SISTEM ===== -->
        @if(in_array(auth()->user()->role, ['admin','manager']))
        @php $sistemActive = request()->is('users*') || request()->is('activity*') || request()->is('admin/settings*'); @endphp
        <div>
            <button onclick="toggleMenu('sistem')"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-all text-sm font-medium
                {{ $sistemActive ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <span class="flex items-center">
                    <i class="fa-solid fa-gear w-5 mr-3 text-center text-slate-400"></i>
                    Sistem
                </span>
                <i id="icon-sistem" class="fa-solid fa-chevron-down text-xs transition-transform duration-300
                {{ $sistemActive ? 'rotate-180' : '' }}"></i>
            </button>

            <div id="menu-sistem"
                class="overflow-hidden transition-all duration-300 ease-in-out
                {{ $sistemActive ? 'max-h-40 opacity-100' : 'max-h-0 opacity-0' }}">
                <div class="mt-1 ml-4 pl-3 border-l border-slate-600 space-y-1 py-1">

                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('users.index') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition-all text-sm
                    {{ request()->is('users*') ? 'bg-blue-600/20 text-blue-400 font-semibold' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                        <i class="fa-solid fa-users w-5 mr-3 text-center"></i> Kelola User
                    </a>
                    @endif

                    <a href="{{ route('activity.index') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition-all text-sm
                    {{ request()->is('activity*') ? 'bg-blue-600/20 text-blue-400 font-semibold' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                        <i class="fa-solid fa-clock-rotate-left w-5 mr-3 text-center"></i> Activity Log
                    </a>

                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.settings') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition-all text-sm
                    {{ request()->is('admin/settings*') ? 'bg-blue-600/20 text-blue-400 font-semibold' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                        <i class="fa-solid fa-sliders w-5 mr-3 text-center"></i> Pengaturan
                    </a>
                    @endif

                </div>
            </div>
        </div>
        @endif

    </nav>

    <!-- User Info + Logout -->
    <div class="p-4 border-t border-slate-700">
    <div class="flex items-center gap-3 mb-3">
        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-full flex items-center justify-center flex-shrink-0">
            <span class="text-white text-sm font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </span>
        </div>
        <div class="overflow-hidden">
            <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
            <p class="text-gray-400 text-xs capitalize">{{ Auth::user()->role }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
        @csrf
        {{-- type="button" agar tidak langsung submit --}}
        <button type="button" onclick="confirmLogout()"
            class="w-full flex items-center justify-center gap-2 bg-red-500/20 hover:bg-red-500/30 text-red-400 px-3 py-2 rounded-lg text-sm font-medium transition-all">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </button>
    </form>
</div>

<script>
function confirmLogout() {
    Swal.fire({
        title: 'Keluar dari aplikasi?',
        text: 'Kamu akan keluar dari sesi ini',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-right-from-bracket mr-1"></i> Ya, Logout',
        cancelButtonText: '<i class="fa-solid fa-xmark mr-1"></i> Tidak',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#475569',
        background: '#1e293b',
        color: '#e2e8f0',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logoutForm').submit();
        }
    });
}
</script>

</aside>
    <!-- MAIN -->
<div class="flex-1 flex flex-col min-w-0">
            <!-- TOPBAR -->
                <header class="bg-slate-800 px-6 py-4 flex items-center border-b border-slate-700">
                <h2 class="text-xl font-semibold">Dashboard</h2>
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

<script>
function toggleMenu(name) {
    const menu = document.getElementById('menu-' + name);
    const icon = document.getElementById('icon-' + name);
    const isOpen = !menu.classList.contains('max-h-0');

    // Tutup semua menu dulu
    ['master', 'transaksi', 'laporan', 'sistem'].forEach(key => {
        const m = document.getElementById('menu-' + key);
        const i = document.getElementById('icon-' + key);
        if (m && i) {
            m.classList.add('max-h-0', 'opacity-0');
            m.classList.remove('max-h-40', 'max-h-20', 'opacity-100');
            i.classList.remove('rotate-180');
        }
    });

    // Buka yang diklik jika sebelumnya tertutup
    if (!isOpen) {
        const maxH = name === 'laporan' ? 'max-h-20' : 'max-h-40';
        menu.classList.remove('max-h-0', 'opacity-0');
        menu.classList.add(maxH, 'opacity-100');
        icon.classList.add('rotate-180');
    }
}


</script>

</body>
@stack('scripts')
</html>