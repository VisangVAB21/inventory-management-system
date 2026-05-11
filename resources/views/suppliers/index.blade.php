<x-app-layout>
<div class="p-6">
    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-white">Manajemen Supplier</h1>
        
        <!-- Button HANYA ADMIN -->
        @if(auth()->user()->role === 'admin')
        @else
            <span class="px-4 py-2 bg-gray-600 text-sm rounded-xl text-gray-300">
                👁️ Hanya View (Admin Only)
            </span>
        @endif
    </div>

    <!-- FORM TAMBAH - HANYA ADMIN -->
    @if(auth()->user()->role === 'admin')
    <div class="bg-slate-800 p-6 rounded-2xl mb-6 shadow-xl border border-slate-700">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-blue-400"></i>
            Tambah Supplier Baru
        </h3>
        
        <form id="formTambah" action="{{ route('suppliers.store') }}" method="POST" 
              class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf
            <input type="text" name="name" placeholder="Nama Supplier" required
                class="p-3 rounded-xl bg-slate-700 border border-slate-600 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
            
            <input type="tel" name="phone" placeholder="08xx-xxxx-xxxx"
                class="p-3 rounded-xl bg-slate-700 border border-slate-600 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
            
            <input type="text" name="address" placeholder="Alamat Lengkap"
                class="p-3 rounded-xl bg-slate-700 border border-slate-600 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 md:col-span-2">
            
            <button type="submit"
                    class="bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 
                           p-3 rounded-xl font-semibold shadow-lg hover:shadow-emerald-500/25 transition-all">
                <i class="fa-solid fa-save mr-2"></i>
                Simpan
            </button>
        </form>
    </div>
    @endif

    <!-- TABLE -->
    <div class="bg-slate-800 rounded-2xl overflow-hidden shadow-2xl">
        <table class="w-full text-sm">
            <thead class="bg-slate-700">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold text-white">Nama Supplier</th>
                    <th class="px-6 py-4 text-left font-semibold text-white">Telepon</th>
                    <th class="px-6 py-4 text-left font-semibold text-white">Alamat</th>
                    @if(auth()->user()->role === 'admin')
                        <th class="px-6 py-4 text-center font-semibold text-white">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $s)
                <tr class="border-b border-slate-700 hover:bg-slate-750 transition-all">
                    <td class="px-6 py-4 font-semibold text-white">
                        {{ $s->name }}
                    </td>
                    <td class="px-6 py-4 text-slate-300">
                        <span class="font-mono">{{ $s->phone ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4 text-slate-300 max-w-md truncate">
                        {{ $s->address ?? '-' }}
                    </td>
                    
                    @if(auth()->user()->role === 'admin')
                    <td class="px-6 py-4">
                        <div class="flex gap-2 justify-center">
                            <!-- EDIT -->
                            <button onclick="openEditModal({{ $s->id }}, '{{ addslashes($s->name) }}', '{{ addslashes($s->phone ?? '') }}', '{{ addslashes($s->address ?? '') }}')"
                                    class="bg-yellow-500 hover:bg-yellow-600 p-2 rounded-lg text-white shadow-md hover:shadow-yellow-400/25 transition-all flex items-center gap-1 text-sm">
                                <i class="fa-solid fa-edit"></i>
                                Edit
                            </button>
                            
                            <!-- DELETE -->
                            <form action="{{ route('suppliers.destroy', $s->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $s->id }})"
                                        class="bg-red-500 hover:bg-red-600 p-2 rounded-lg text-white shadow-md hover:shadow-red-400/25 transition-all flex items-center gap-1 text-sm">
                                    <i class="fa-solid fa-trash"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role === 'admin' ? 4 : 3 }}" 
                        class="text-center py-12 text-slate-400">
                        <i class="fa-solid fa-users text-4xl mb-4 opacity-50"></i>
                        <p>Belum ada data supplier</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL EDIT - HANYA ADMIN -->
@if(auth()->user()->role === 'admin')
<div id="editModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
    <div class="bg-slate-800 p-8 rounded-2xl w-full max-w-lg shadow-2xl border border-slate-700">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                <i class="fa-solid fa-user-edit text-yellow-400"></i>
                Edit Supplier
            </h2>
            <button onclick="closeEditModal()" class="text-2xl text-gray-400 hover:text-white">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        
        <form id="editForm" method="POST" class="space-y-4">
            @csrf @method('PUT')
            
            <input id="editId" type="hidden" name="id">
            <input id="editName" type="text" name="name" required
                class="w-full p-4 rounded-xl bg-slate-700 border border-slate-600 focus:border-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500/50">
            
            <input id="editPhone" type="tel" name="phone"
                class="w-full p-4 rounded-xl bg-slate-700 border border-slate-600 focus:border-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500/50">
            
            <input id="editAddress" type="text" name="address"
                class="w-full p-4 rounded-xl bg-slate-700 border border-slate-600 focus:border-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500/50">
            
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeEditModal()"
                        class="px-6 py-3 bg-gray-600 hover:bg-gray-700 rounded-xl transition-all">
                    <i class="fa-solid fa-times mr-2"></i>Batal
                </button>
                <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 rounded-xl font-semibold shadow-lg transition-all">
                    <i class="fa-solid fa-check mr-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Form Tambah Confirmation
@if(auth()->user()->role === 'admin')
document.getElementById('formTambah')?.addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Tambah Supplier?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, simpan!'
    }).then(result => {
        if (result.isConfirmed) this.submit();
    });
});
@endif

// Edit Modal
function openEditModal(id, name, phone, address) {
    document.getElementById('editId').value = id;
    document.getElementById('editName').value = name;
    document.getElementById('editPhone').value = phone;
    document.getElementById('editAddress').value = address;
    document.getElementById('editForm').action = `/suppliers/${id}`;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Delete Confirmation
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Supplier?',
        text: 'Data tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus!'
    }).then(result => {
        if (result.isConfirmed) {
            fetch(`/suppliers/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
            }).then(() => {
                location.reload();
            });
        }
    });
}
</script>

<!-- Toast Messages -->
@if(session('success'))
<script>
Swal.fire({
    toast: true, position: 'top-end', icon: 'success',
    title: '{{ session('success') }}', timer: 3000, showConfirmButton: false
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    toast: true, position: 'top-end', icon: 'error',
    title: '{{ session('error') }}', timer: 3000, showConfirmButton: false
});
</script>
@endif

<meta name="csrf-token" content="{{ csrf_token() }}">
</x-app-layout>