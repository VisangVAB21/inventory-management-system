<x-app-layout>
<style>
.swal2-input {
    background-color: #0f172a !important;
    color: #e2e8f0 !important;
    border: 1px solid #334155 !important;
}
.swal2-input:focus {
    border-color: #3b82f6 !important;
    box-shadow: none !important;
}
</style>

<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Manajemen Kategori</h1>

        @if(in_array(auth()->user()->role, ['admin','staff']))
        <button onclick="addCategory()"
            class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white font-semibold shadow">
            + Tambah Kategori
        </button>
        @endif
    </div>

    <!-- SEARCH -->
    <div class="mb-4">
        <input id="searchKategori" type="text" placeholder="Cari kategori..."
            class="w-full md:w-1/3 px-4 py-2 rounded-lg bg-slate-800 text-white border border-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- TABLE -->
    <div class="bg-slate-800 rounded-xl shadow-lg overflow-hidden">
        <table class="w-full text-sm text-left text-gray-300">
            <thead class="bg-slate-700 text-gray-200 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama Kategori</th>
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-700">
                @foreach($categories as $index => $cat)
                <tr class="hover:bg-slate-700 transition">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>

                    <td class="px-6 py-4 font-semibold text-white">{{ $cat->name }}</td>

                    <td class="px-6 py-4">KAT-{{ str_pad($cat->id, 3, '0', STR_PAD_LEFT) }}</td>

                    <td class="px-6 py-4 text-center space-x-2">

                        @if(in_array(auth()->user()->role, ['admin','staff']))
                        <button onclick="editCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}')"
                            class="text-yellow-400 hover:text-yellow-300">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        @endif

                        @if(auth()->user()->role == 'admin')
                        <button onclick="deleteCategory({{ $cat->id }})"
                            class="text-red-500 hover:text-red-400">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

// ================= SEARCH =================
document.getElementById('searchKategori').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});

// ================= ADD =================
// ================= ADD =================
function addCategory() {
    Swal.fire({
        title: 'Tambah Kategori',
        input: 'text',
        inputPlaceholder: 'Nama kategori...',
        background: '#1e293b',
        color: '#e2e8f0',
        inputAttributes: { autocapitalize: 'off' },
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#64748b'
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            fetch('/categories', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name: result.value })
            }).then(res => {
                if (res.ok) {
                    // ✅ Notif berhasil tambah
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Kategori berhasil ditambahkan',
                        background: '#1e293b',
                        color: '#e2e8f0',
                        confirmButtonColor: '#3b82f6',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal menambahkan kategori',
                        background: '#1e293b',
                        color: '#e2e8f0',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        }
    });
}

// ================= EDIT ================= ✅ DIPERBAIKI
// ================= EDIT =================
function editCategory(id, name) {
    Swal.fire({
        title: 'Edit Kategori',
        input: 'text',
        inputValue: name,
        background: '#1e293b',
        color: '#e2e8f0',
        inputAttributes: { autocapitalize: 'off' },
        showCancelButton: true,
        confirmButtonText: 'Update',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#facc15',
        cancelButtonColor: '#64748b'
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            fetch('/categories/' + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-HTTP-Method-Override': 'PUT'
                },
                body: JSON.stringify({
                    _method: 'PUT',
                    name: result.value
                })
            }).then(res => {
                if (res.ok) {
                    // ✅ Notif berhasil edit
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Kategori berhasil diperbarui',
                        background: '#1e293b',
                        color: '#e2e8f0',
                        confirmButtonColor: '#facc15',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal mengupdate', background: '#1e293b', color: '#e2e8f0' });
                }
            });
        }
    });
}

// ================= DELETE =================
function deleteCategory(id) {
    Swal.fire({
        title: 'Hapus kategori?',
        text: 'Data tidak bisa dikembalikan',
        icon: 'warning',
        background: '#1e293b',
        color: '#e2e8f0',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            formData.append('_token', '{{ csrf_token() }}');

            fetch('/categories/' + id, {
                method: 'POST',
                body: formData
            }).then(res => {
                if (res.ok) {
                    // ✅ Notif berhasil delete
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: 'Kategori berhasil dihapus',
                        background: '#1e293b',
                        color: '#e2e8f0',
                        confirmButtonColor: '#ef4444',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal menghapus', background: '#1e293b', color: '#e2e8f0' });
                }
            });
        }
    });
}


</script>
</x-app-layout>