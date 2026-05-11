<x-app-layout>
<div class="p-6">
    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Activity Log</h1>
    </div>

    <!-- SEARCH -->
    <div class="mb-4">
        <input id="searchLog" type="text" placeholder="Cari aktivitas..."
            class="w-full md:w-1/3 px-4 py-2 rounded-lg bg-slate-800 text-white border border-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- TABLE -->
    <div class="bg-slate-800 rounded-xl shadow-lg overflow-hidden">
        <table class="w-full text-sm text-left text-gray-300">
            <thead class="bg-slate-700 text-gray-200 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">User</th>
                    <th class="px-6 py-3">Aksi</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse($logs as $index => $log)
                <tr class="hover:bg-slate-700 transition">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    
                    <td class="px-6 py-4 font-semibold text-white">
                        {{ $log->user->name ?? 'Unknown' }}
                    </td>

                    <!-- Kolom Aksi -->
                    <td class="px-6 py-4">
                        @php
                            $badgeColor = match(true) {
                                str_contains($log->action, 'Tambah') => 'bg-blue-500/20 text-blue-400',
                                str_contains($log->action, 'Update') => 'bg-yellow-500/20 text-yellow-400',
                                str_contains($log->action, 'Hapus') => 'bg-red-500/20 text-red-400',
                                str_contains($log->action, 'Stock In') => 'bg-green-500/20 text-green-400',
                                str_contains($log->action, 'Stock Out') => 'bg-orange-500/20 text-orange-400',
                                default => 'bg-slate-500/20 text-slate-400',
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                            {{ $log->action }}
                        </span>
                    </td>

                    <!-- Deskripsi -->
                    <td class="px-6 py-4 text-gray-400">
                        {{ $log->description ?? '-' }}
                    </td>

                    <!-- Kolom Waktu (Diperbaiki) -->
                    <td class="px-6 py-4 text-gray-400">
                        @if($log->created_at)
                            <span class="block">
                                {{ $log->created_at->format('d M Y') }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ $log->created_at->format('H:i:s') }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Belum ada aktivitas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('searchLog').addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            if (row.querySelector('td[colspan="5"]')) return; // skip empty row
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>
</x-app-layout>