<x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.swal2-input, .swal2-select, .swal2-textarea {
    background-color: #0f172a !important;
    color: #e2e8f0 !important;
    border: 1px solid #334155 !important;
}
.swal2-input:focus, .swal2-textarea:focus {
    border-color: #3b82f6 !important;
}
</style>

<div class="p-6">
    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Manajemen Produk</h1>
        @if(in_array(auth()->user()->role, ['admin','manager']))
        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white font-semibold shadow">
            + Tambah Produk
        </button>
        @endif
    </div>

    <!-- SEARCH -->
    <div class="mb-4">
        <input id="searchProduk" type="text" placeholder="Cari produk..."
            class="w-full md:w-1/3 px-4 py-2 rounded-lg bg-slate-800 text-white border border-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- TABLE -->
    <div class="bg-slate-800 rounded-xl shadow-lg overflow-hidden overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-300">
            <thead class="bg-slate-700 text-gray-200 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Gambar</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3">Harga Beli</th>
                    <th class="px-6 py-3">Harga Jual</th>
                    <th class="px-6 py-3">Stok Awal</th>
                    <th class="px-6 py-3">Stok</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @foreach($products as $index => $p)
                <tr class="hover:bg-slate-700 transition">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        @if($p->image)
                            <img src="{{ asset('storage/' . $p->image) }}" 
                                 alt="{{ $p->name }}" 
                                 class="w-12 h-12 object-cover rounded-lg border border-slate-600 shadow-sm">
                        @else
                            <div class="w-12 h-12 bg-slate-700 rounded-lg flex items-center justify-center text-xs text-gray-500">
                                No Img
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-semibold text-white">{{ $p->name }}</td>
                    <td class="px-6 py-4">{{ $p->category->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-400 max-w-xs truncate" title="{{ $p->description ?? '' }}">
                        {{ Str::limit($p->description, 60) ?? '-' }}
                    </td>
                    <td class="px-6 py-4">Rp {{ number_format($p->buy_price ?? 0) }}</td>
                    <td class="px-6 py-4 font-medium text-emerald-400">Rp {{ number_format($p->price ?? 0) }}</td>
                    <td class="px-6 py-4">{{ $p->initial_stock ?? 0 }}</td>
                    <td class="px-6 py-4 font-semibold {{ $p->stock < 10 ? 'text-orange-400' : 'text-white' }}">
                        {{ $p->stock }}
                    </td>
                    <!-- AKSI -->
<td class="px-6 py-4 text-center">
    <div class="flex justify-center gap-4">
        @if(in_array(auth()->user()->role, ['admin','manager']))
        <button onclick="editProduct({{ $p->id }})" 
                class="text-yellow-400 hover:text-yellow-300 transition-colors">
            <i class="fa-solid fa-pen fa-lg"></i>
        </button>
        @endif

        @if(auth()->user()->role == 'admin')
        <button onclick="deleteProduct({{ $p->id }})" 
                class="text-red-500 hover:text-red-400 transition-colors">
            <i class="fa-solid fa-trash fa-lg"></i>
        </button>
        @endif
        @if(in_array(auth()->user()->role, ['manager','staff']))
        <button onclick="stockOpname({{ $p->id }}, {{ $p->stock }})" 
                class="text-blue-400 hover:text-blue-300 transition-colors"
                title="Stock Opname">
            <i class="fa-solid fa-magnifying-glass-chart fa-lg"></i>
        </button>
        @endif
    </div>
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL -->
<div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center z-50">
    <div class="bg-slate-800 p-6 rounded-xl w-full max-w-xl max-h-[95vh] overflow-hidden flex flex-col shadow-2xl">
        
        <h2 id="modalTitle" class="text-white text-lg font-bold mb-4">Tambah Produk</h2>
        
        <div class="flex-1 overflow-y-auto pr-2 space-y-4 custom-scroll">
            <!-- Gambar -->
            <div>
                <label class="block text-xs text-gray-400 mb-1">Gambar Produk</label>
                <input id="f_image" type="file" accept="image/*" 
                       class="w-full p-2 rounded bg-slate-700 text-white border border-slate-600">
                <div id="imagePreview" class="mt-3 hidden">
                    <img class="w-28 h-28 object-cover rounded-lg border border-slate-600" alt="preview">
                </div>
            </div>

            <input id="f_name" type="text" placeholder="Nama Produk" 
                   class="w-full p-3 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <textarea id="f_description" rows="3" placeholder="Deskripsi produk..." 
                      class="w-full p-3 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Harga Beli (Rp)</label>
                    <input id="f_buy_price" type="number" placeholder="0" 
                           class="w-full p-3 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Harga Jual (Rp)</label>
                    <input id="f_price" type="number" placeholder="0" 
                           class="w-full p-3 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <input id="f_stock" type="number" placeholder="Stok Saat Ini" 
                       class="w-full p-3 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input id="f_initial_stock" type="number" placeholder="Stok Awal" 
                       class="w-full p-3 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <select id="f_category" class="w-full p-3 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>

            <div class="grid grid-cols-3 gap-4">
                <input id="f_merk" type="text" placeholder="Merk" 
                       class="w-full p-3 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input id="f_warna" type="text" placeholder="Warna" 
                       class="w-full p-3 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <select id="f_ukuran" class="w-full p-3 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Ukuran</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                </select>
            </div>
        </div>

        <!-- Footer Buttons -->
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-700">
            <button onclick="closeModal()" 
                    class="bg-slate-600 hover:bg-slate-500 px-5 py-2.5 rounded text-white font-medium">
                Batal
            </button>
            <button id="btnSimpan" onclick="submitProduct()" 
                    class="bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded text-white font-semibold">
                Simpan
            </button>
        </div>
    </div>
</div>

<script>
    let currentMode = 'add';
    let currentEditId = null;

    function openModal() {
        currentMode = 'add';
        currentEditId = null;
        document.getElementById('modalTitle').innerText = 'Tambah Produk';
        document.getElementById('btnSimpan').className = 'bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded text-white font-semibold';

        // Reset form
        document.getElementById('f_name').value = '';
        document.getElementById('f_description').value = '';
        document.getElementById('f_price').value = '';
        document.getElementById('f_buy_price').value = '';
        document.getElementById('f_stock').value = '';
        document.getElementById('f_initial_stock').value = '';
        document.getElementById('f_category').selectedIndex = 0;
        document.getElementById('f_merk').value = '';
        document.getElementById('f_warna').value = '';
        document.getElementById('f_ukuran').value = '';
        document.getElementById('f_image').value = '';
        document.getElementById('imagePreview').classList.add('hidden');

        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }

// ================= EDIT PRODUK =================
function editProduct(id) {
    fetch(`/products/${id}/edit`)
        .then(res => {
            if (!res.ok) throw new Error('Gagal mengambil data');
            return res.json();
        })
        .then(data => {
            currentMode = 'edit';
            currentEditId = id;

            document.getElementById('modalTitle').innerText = 'Edit Produk';
            document.getElementById('btnSimpan').className = 'bg-yellow-500 hover:bg-yellow-400 px-5 py-2.5 rounded text-white font-semibold';

            // Isi form
            document.getElementById('f_name').value = data.name || '';
            document.getElementById('f_description').value = data.description || '';
            document.getElementById('f_buy_price').value = data.buy_price || 0;
            document.getElementById('f_price').value = data.price || 0;
            document.getElementById('f_stock').value = data.stock || 0;
            document.getElementById('f_initial_stock').value = data.initial_stock || 0;
            document.getElementById('f_category').value = data.category_id || '';
            document.getElementById('f_merk').value = data.merk || '';
            document.getElementById('f_warna').value = data.warna || '';
            document.getElementById('f_ukuran').value = data.ukuran || '';

            // Preview Gambar
            const previewDiv = document.getElementById('imagePreview');
            if (data.image_url) {
                previewDiv.innerHTML = `<img src="${data.image_url}" class="w-28 h-28 object-cover rounded-lg border border-slate-600">`;
                previewDiv.classList.remove('hidden');
            } else {
                previewDiv.classList.add('hidden');
            }

            document.getElementById('modal').classList.remove('hidden');
        })
        .catch(error => {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Tidak bisa mengambil data produk untuk diedit',
                background: '#1e293b',
                color: '#e2e8f0'
            });
        });
}
    // Submit (Add & Edit)
    function submitProduct() {
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('name', document.getElementById('f_name').value.trim());
        formData.append('description', document.getElementById('f_description').value.trim());
        formData.append('price', document.getElementById('f_price').value);
        formData.append('buy_price', document.getElementById('f_buy_price').value);
        formData.append('stock', document.getElementById('f_stock').value);
        formData.append('initial_stock', document.getElementById('f_initial_stock').value);
        formData.append('category_id', document.getElementById('f_category').value);
        formData.append('merk', document.getElementById('f_merk').value.trim());
        formData.append('warna', document.getElementById('f_warna').value.trim());
        formData.append('ukuran', document.getElementById('f_ukuran').value);

        if (document.getElementById('f_image').files[0]) {
            formData.append('image', document.getElementById('f_image').files[0]);
        }

        const isEdit = currentMode === 'edit';
        const url = isEdit ? `/products/${currentEditId}` : '/products';
        if (isEdit) formData.append('_method', 'PUT');

        fetch(url, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(async res => {
            const data = await res.json().catch(() => null);
            if (res.ok) {
                closeModal();
                Swal.fire({
                    icon: 'success',
                    title: isEdit ? 'Berhasil Diupdate' : 'Produk Ditambahkan',
                    timer: 1500,
                    showConfirmButton: false,
                    background: '#1e293b',
                    color: '#e2e8f0'
                }).then(() => location.reload());
            } else {
                let msg = 'Terjadi kesalahan';
                if (data?.errors) msg = Object.values(data.errors).flat().join('\n');
                Swal.fire({ icon: 'error', title: 'Gagal', text: msg, background: '#1e293b', color: '#e2e8f0' });
            }
        })
        .catch(() => Swal.fire({ icon: 'error', title: 'Koneksi Bermasalah', background: '#1e293b', color: '#e2e8f0' }));
    }

    // Delete, Search, dan lainnya tetap sama...
   // ================= DELETE PRODUK =================
function deleteProduct(id) {
    Swal.fire({
        title: 'Hapus produk ini?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        background: '#1e293b',
        color: '#e2e8f0'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'DELETE');

            fetch(`/products/${id}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(async res => {
                const data = await res.json().catch(() => ({}));

                if (res.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: 'Produk berhasil dihapus',
                        timer: 1500,
                        showConfirmButton: false,
                        background: '#1e293b',
                        color: '#e2e8f0'
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Gagal menghapus produk',
                        background: '#1e293b',
                        color: '#e2e8f0'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Koneksi Bermasalah',
                    text: 'Silakan cek console (F12)',
                    background: '#1e293b',
                    color: '#e2e8f0'
                });
            });
        }
    });
}

// ================= STOCK OPNAME =================
function stockOpname(id, stokSistem) {
    Swal.fire({
        title: 'Stock Opname',
        html: `
            <div style="text-align:left">
                <p>Stok Sistem: <b>${stokSistem}</b></p>
                <input id="stok_fisik" type="number" class="swal2-input" placeholder="Masukkan stok fisik">
            </div>
        `,
        confirmButtonText: 'Simpan',
        showCancelButton: true,
        background: '#1e293b',
        color: '#e2e8f0',
        preConfirm: () => {
            const stokFisik = document.getElementById('stok_fisik').value;
            if (!stokFisik) {
                Swal.showValidationMessage('Stok fisik wajib diisi');
            }
            return stokFisik;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const stokFisik = parseInt(result.value);
            const selisih = stokFisik - stokSistem;

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('stok_fisik', stokFisik);
            formData.append('selisih', selisih);

            fetch(`/products/${id}/opname`, {
                method: 'POST',
                headers: { 
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(async res => {
                const data = await res.json().catch(() => ({}));

                if (res.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Opname Berhasil',
                        text: `Selisih: ${selisih}`,
                        background: '#1e293b',
                        color: '#e2e8f0'
                    }).then(() => location.reload());
                } else {
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
                Swal.fire({
                    icon: 'error',
                    title: 'Koneksi Bermasalah',
                    background: '#1e293b',
                    color: '#e2e8f0'
                });
            });
        }
    });
}

// ================= SEARCH =================
document.getElementById('searchProduk').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});

// Tutup modal klik backdrop
document.getElementById('modal').addEventListener('click', function (e) {
    if (e.target === this) closeModal();
});

// Preview gambar sebelum upload
document.getElementById('f_image').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const previewDiv = document.getElementById('imagePreview');
            previewDiv.innerHTML = `<img src="${e.target.result}" class="w-28 h-28 object-cover rounded-lg border border-slate-600">`;
            previewDiv.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});

</script>

</x-app-layout>