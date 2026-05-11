<x-app-layout>

{{-- ================================================================
     ADMIN DASHBOARD
================================================================ --}}
@if(Auth::user()->role == 'admin')

<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Admin Dashboard</h1>
            <p class="text-gray-400 text-sm mt-1">Selamat datang, {{ Auth::user()->name }}</p>
        </div>
        <span class="px-3 py-1 bg-blue-600/20 text-blue-400 text-xs font-semibold rounded-full border border-blue-500/30">
            Administrator
        </span>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-box text-blue-400 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase">Total Produk</p>
                <p class="text-2xl font-bold text-white">{{ $data['total_produk'] }}</p>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-arrow-down text-green-400 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase">Total Barang Masuk</p>
                <p class="text-2xl font-bold text-white">{{ $data['total_stock_in'] }}</p>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700 flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-500/20 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-arrow-up text-orange-400 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase">Total Barang Keluar</p>
                <p class="text-2xl font-bold text-white">{{ $data['total_stock_out'] }}</p>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation text-red-400 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase">Stok Menipis</p>
                <p class="text-2xl font-bold text-white">{{ $data['low_stock'] }}</p>
            </div>
        </div>

    </div>

    <!-- CHART + ACTIVITY -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- CHART -->
        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700">
            <h3 class="text-white font-semibold mb-4">
                <i class="fa-solid fa-chart-bar mr-2 text-blue-400"></i>Grafik Stok Produk
            </h3>
            <canvas id="stockChart" height="200"></canvas>
        </div>

        <!-- ACTIVITY LOG -->
        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700">
            <h3 class="text-white font-semibold mb-4">
                <i class="fa-solid fa-clock-rotate-left mr-2 text-purple-400"></i>Aktivitas Terbaru
            </h3>
            <div class="space-y-3 overflow-y-auto max-h-64">
                @forelse($data['recent_activity'] as $log)
                <div class="flex items-start gap-3 p-3 bg-slate-700/50 rounded-lg">
                    <div class="w-8 h-8 bg-purple-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-user text-purple-400 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold">{{ $log->user->name ?? 'Unknown' }}</p>
                        <p class="text-gray-400 text-xs">{{ $log->action }} — {{ $log->description }}</p>
                        <p class="text-gray-500 text-xs mt-1">
                            {{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Jakarta')->diffForHumans() }}
                        </p>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm text-center py-4">Belum ada aktivitas</p>
                @endforelse
            </div>
        </div>

    </div>

</div>

<!-- CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('stockChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($data['chart_labels']) !!},
            datasets: [{
                label: 'Stok',
                data: {!! json_encode($data['chart_data']) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { labels: { color: '#e2e8f0' } }
            },
            scales: {
                x: { ticks: { color: '#94a3b8' }, grid: { color: '#334155' } },
                y: { ticks: { color: '#94a3b8' }, grid: { color: '#334155' }, beginAtZero: true }
            }
        }
    });
</script>


{{-- ================================================================
     MANAGER DASHBOARD
================================================================ --}}
@elseif(Auth::user()->role == 'manager')

<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajer Dashboard</h1>
            <p class="text-gray-400 text-sm mt-1">Selamat datang, {{ Auth::user()->name }}</p>
        </div>
        <span class="px-3 py-1 bg-emerald-600/20 text-emerald-400 text-xs font-semibold rounded-full border border-emerald-500/30">
            Manajer Gudang
        </span>
    </div>

    <!-- RINGKASAN HARI INI -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation text-red-400 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase">Stok Menipis</p>
                <p class="text-2xl font-bold text-red-400">{{ $data['low_stock_products']->count() }}</p>
                <p class="text-gray-500 text-xs">produk perlu restock</p>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-arrow-down text-green-400 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase">Masuk Hari Ini</p>
                <p class="text-2xl font-bold text-green-400">{{ $data['total_masuk_hari'] }}</p>
                <p class="text-gray-500 text-xs">unit barang masuk</p>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700 flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-500/20 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-arrow-up text-orange-400 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase">Keluar Hari Ini</p>
                <p class="text-2xl font-bold text-orange-400">{{ $data['total_keluar_hari'] }}</p>
                <p class="text-gray-500 text-xs">unit barang keluar</p>
            </div>
        </div>

    </div>

    <!-- STOK MENIPIS -->
    @if($data['low_stock_products']->count() > 0)
    <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-5 shadow">
        <h3 class="text-red-400 font-semibold mb-3">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan Stok Menipis
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            @foreach($data['low_stock_products'] as $product)
            <div class="bg-slate-800 rounded-lg p-3 flex justify-between items-center">
                <div>
                    <p class="text-white text-sm font-semibold">{{ $product->name }}</p>
                    <p class="text-gray-400 text-xs">{{ $product->category->name ?? '-' }}</p>
                </div>
                <span class="px-2 py-1 bg-red-500/20 text-red-400 text-xs font-bold rounded-full">
                    {{ $product->stock }} unit
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- BARANG MASUK & KELUAR HARI INI -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- MASUK HARI INI -->
        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700">
            <h3 class="text-white font-semibold mb-4">
                <i class="fa-solid fa-arrow-down mr-2 text-green-400"></i>Barang Masuk Hari Ini
            </h3>
            <div class="space-y-2 max-h-60 overflow-y-auto">
                @forelse($data['stock_in_today'] as $item)
                <div class="flex justify-between items-center p-3 bg-slate-700/50 rounded-lg">
                    <div>
                        <p class="text-white text-sm font-semibold">{{ $item->product->name ?? '-' }}</p>
                        <p class="text-gray-400 text-xs">{{ $item->supplier->name ?? '-' }}</p>
                    </div>
                    <span class="text-green-400 font-bold text-sm">+{{ $item->qty }}</span>
                </div>
                @empty
                <p class="text-gray-500 text-sm text-center py-4">Belum ada barang masuk hari ini</p>
                @endforelse
            </div>
        </div>

        <!-- KELUAR HARI INI -->
        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700">
            <h3 class="text-white font-semibold mb-4">
                <i class="fa-solid fa-arrow-up mr-2 text-orange-400"></i>Barang Keluar Hari Ini
            </h3>
            <div class="space-y-2 max-h-60 overflow-y-auto">
                @forelse($data['stock_out_today'] as $item)
                <div class="flex justify-between items-center p-3 bg-slate-700/50 rounded-lg">
                    <div>
                        <p class="text-white text-sm font-semibold">{{ $item->product->name ?? '-' }}</p>
                        <p class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</p>
                    </div>
                    <span class="text-orange-400 font-bold text-sm">-{{ $item->qty }}</span>
                </div>
                @empty
                <p class="text-gray-500 text-sm text-center py-4">Belum ada barang keluar hari ini</p>
                @endforelse
            </div>
        </div>

    </div>

</div>


{{-- ================================================================
     STAFF DASHBOARD
================================================================ --}}
@elseif(Auth::user()->role == 'staff')

<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Staff Dashboard</h1>
            <p class="text-gray-400 text-sm mt-1">Selamat datang, {{ Auth::user()->name }}</p>
        </div>
        <span class="px-3 py-1 bg-cyan-600/20 text-cyan-400 text-xs font-semibold rounded-full border border-cyan-500/30">
            Staff Gudang
        </span>
    </div>

    <!-- TASK SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-clipboard-check text-green-400 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase">Barang Masuk Hari Ini</p>
                <p id="countStockIn" class="text-2xl font-bold text-green-400">{{ $data['stock_in_pending']->count() }}</p>
                <p class="text-gray-500 text-xs">transaksi perlu dicek</p>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700 flex items-center gap-4">
            <div class="w-12 h-12 bg-cyan-500/20 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-boxes-packing text-cyan-400 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase">Barang Keluar Hari Ini</p>
                <p id="countStockOut" class="text-2xl font-bold text-cyan-400">{{ $data['stock_out_pending']->count() }}</p>
                <p class="text-gray-500 text-xs">transaksi perlu disiapkan</p>
            </div>
        </div>
    </div>

    <!-- TO-DO LIST -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- BARANG MASUK -->
        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700">
            <h3 class="text-white font-semibold mb-4">
                <i class="fa-solid fa-clipboard-list mr-2 text-green-400"></i>
                Barang Masuk yang Harus Dicek
            </h3>
            <div id="listStockIn" class="space-y-2 max-h-72 overflow-y-auto">
                @forelse($data['stock_in_pending'] as $index => $item)
                <div id="stock-in-{{ $item->id }}" class="flex items-center gap-3 p-3 bg-slate-700/50 rounded-lg border border-slate-600 transition-all">
                    <div class="w-6 h-6 rounded-full border-2 border-green-400 flex items-center justify-center flex-shrink-0">
                        <span class="text-green-400 text-xs font-bold">{{ $index + 1 }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-white text-sm font-semibold">{{ $item->product->name ?? '-' }}</p>
                        <p class="text-gray-400 text-xs">
                            Supplier: {{ $item->supplier->name ?? '-' }} &nbsp;|&nbsp;
                            Qty: <span class="text-green-400 font-semibold">{{ $item->qty }} unit</span>
                        </p>
                    </div>
                    <!-- ✅ Tombol Cek dengan AJAX -->
                    <button
                        onclick="checkStockIn({{ $item->id }}, this)"
                        class="px-2 py-1 bg-green-500/20 text-green-400 text-xs rounded-full font-semibold hover:bg-green-500/40 transition-colors">
                        <i class="fa-solid fa-check mr-1"></i>Cek
                    </button>
                </div>
                @empty
                <div id="emptyStockIn" class="text-center py-8">
                    <i class="fa-solid fa-circle-check text-green-400 text-3xl mb-2"></i>
                    <p class="text-gray-500 text-sm">Semua barang masuk sudah dicek</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- BARANG KELUAR -->
        <div class="bg-slate-800 rounded-xl p-5 shadow border border-slate-700">
            <h3 class="text-white font-semibold mb-4">
                <i class="fa-solid fa-boxes-packing mr-2 text-cyan-400"></i>
                Barang Keluar yang Harus Disiapkan
            </h3>
            <div id="listStockOut" class="space-y-2 max-h-72 overflow-y-auto">
                @forelse($data['stock_out_pending'] as $index => $item)
                <div id="stock-out-{{ $item->id }}" class="flex items-center gap-3 p-3 bg-slate-700/50 rounded-lg border border-slate-600 transition-all">
                    <div class="w-6 h-6 rounded-full border-2 border-cyan-400 flex items-center justify-center flex-shrink-0">
                        <span class="text-cyan-400 text-xs font-bold">{{ $index + 1 }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-white text-sm font-semibold">{{ $item->product->name ?? '-' }}</p>
                        <p class="text-gray-400 text-xs">
                            Qty: <span class="text-cyan-400 font-semibold">{{ $item->qty }} unit</span>
                        </p>
                    </div>
                    <!-- ✅ Tombol Siapkan dengan AJAX -->
                    <button
                        onclick="prepareStockOut({{ $item->id }}, this)"
                        class="px-2 py-1 bg-cyan-500/20 text-cyan-400 text-xs rounded-full font-semibold hover:bg-cyan-500/40 transition-colors">
                        <i class="fa-solid fa-check mr-1"></i>Siapkan
                    </button>
                </div>
                @empty
                <div id="emptyStockOut" class="text-center py-8">
                    <i class="fa-solid fa-circle-check text-cyan-400 text-3xl mb-2"></i>
                    <p class="text-gray-500 text-sm">Semua barang keluar sudah disiapkan</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<!-- ✅ SCRIPT AJAX CEK & SIAPKAN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ===== CEK BARANG MASUK =====
function checkStockIn(id, btn) {
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i>Proses...';

    fetch(`/stock-in/${id}/check`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-HTTP-Method-Override': 'PATCH'
        },
        body: (() => {
            const fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('_method', 'PATCH');
            return fd;
        })()
    })
    .then(async res => {
        const data = await res.json().catch(() => ({}));
        if (res.ok) {
            // Hapus item dari list dengan animasi
            const item = document.getElementById(`stock-in-${id}`);
            item.style.transition = 'all 0.3s ease';
            item.style.opacity = '0';
            item.style.transform = 'translateX(20px)';

            setTimeout(() => {
                item.remove();

                // Update counter
                const counter = document.getElementById('countStockIn');
                counter.innerText = Math.max(0, parseInt(counter.innerText) - 1);

                // Tampil empty state jika sudah kosong
                const list = document.getElementById('listStockIn');
                if (list.querySelectorAll('[id^="stock-in-"]').length === 0) {
                    list.innerHTML = `
                        <div class="text-center py-8">
                            <i class="fa-solid fa-circle-check text-green-400 text-3xl mb-2"></i>
                            <p class="text-gray-500 text-sm">Semua barang masuk sudah dicek</p>
                        </div>`;
                }
            }, 300);

            // Toast notifikasi
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Barang berhasil dicek!',
                showConfirmButton: false,
                timer: 2000,
                background: '#1e293b',
                color: '#e2e8f0'
            });
        } else {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check mr-1"></i>Cek';
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message || 'Terjadi kesalahan',
                background: '#1e293b',
                color: '#e2e8f0'
            });
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-check mr-1"></i>Cek';
        Swal.fire({ icon: 'error', title: 'Koneksi Bermasalah', background: '#1e293b', color: '#e2e8f0' });
    });
}

// ===== SIAPKAN BARANG KELUAR =====
function prepareStockOut(id, btn) {
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i>Proses...';

    fetch(`/stock-out/${id}/prepare`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-HTTP-Method-Override': 'PATCH'
        },
        body: (() => {
            const fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('_method', 'PATCH');
            return fd;
        })()
    })
    .then(async res => {
        const data = await res.json().catch(() => ({}));
        if (res.ok) {
            // Hapus item dari list dengan animasi
            const item = document.getElementById(`stock-out-${id}`);
            item.style.transition = 'all 0.3s ease';
            item.style.opacity = '0';
            item.style.transform = 'translateX(20px)';

            setTimeout(() => {
                item.remove();

                // Update counter
                const counter = document.getElementById('countStockOut');
                counter.innerText = Math.max(0, parseInt(counter.innerText) - 1);

                // Tampil empty state jika sudah kosong
                const list = document.getElementById('listStockOut');
                if (list.querySelectorAll('[id^="stock-out-"]').length === 0) {
                    list.innerHTML = `
                        <div class="text-center py-8">
                            <i class="fa-solid fa-circle-check text-cyan-400 text-3xl mb-2"></i>
                            <p class="text-gray-500 text-sm">Semua barang keluar sudah disiapkan</p>
                        </div>`;
                }
            }, 300);

            // Toast notifikasi
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Barang berhasil disiapkan!',
                showConfirmButton: false,
                timer: 2000,
                background: '#1e293b',
                color: '#e2e8f0'
            });
        } else {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check mr-1"></i>Siapkan';
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message || 'Terjadi kesalahan',
                background: '#1e293b',
                color: '#e2e8f0'
            });
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-check mr-1"></i>Siapkan';
        Swal.fire({ icon: 'error', title: 'Koneksi Bermasalah', background: '#1e293b', color: '#e2e8f0' });
    });
}
</script>

@endif

</x-app-layout>