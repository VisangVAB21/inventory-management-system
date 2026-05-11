<div class="flex min-h-screen bg-slate-900 text-white">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-800 p-5 hidden md:block">
        <h1 class="text-2xl font-bold mb-8">Stockify</h1>

        <nav class="space-y-4">
            <a href="/dashboard" class="block hover:text-blue-400">Dashboard</a>
            <a href="#" class="block hover:text-blue-400">Produk</a>
            <a href="#" class="block hover:text-blue-400">Kategori</a>
            <a href="#" class="block hover:text-blue-400">Supplier</a>
            <a href="#" class="block hover:text-blue-400">Transaksi</a>
        </nav>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col">

        <!-- Navbar -->
        <div class="bg-slate-800 p-4 flex justify-between">
            <span>Halo, {{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 px-3 py-1 rounded">Logout</button>
            </form>
        </div>

        <!-- Content -->
        <main class="p-6">
            {{ $slot }}
        </main>

    </div>

</div>