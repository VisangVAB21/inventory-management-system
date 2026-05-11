@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-xl font-semibold text-white mb-4">Kelola User</h1>

    {{-- FORM TAMBAH --}}
    <form method="POST" action="{{ route('users.store') }}" class="mb-6 bg-slate-800 p-4 rounded">
        @csrf

        <div class="grid grid-cols-4 gap-3">
            <input type="text" name="name" placeholder="Nama"
                class="p-2 rounded bg-slate-700 text-white">

            <input type="email" name="email" placeholder="Email"
                class="p-2 rounded bg-slate-700 text-white">

            <input type="password" name="password" placeholder="Password"
                class="p-2 rounded bg-slate-700 text-white">

            <select name="role" class="p-2 rounded bg-slate-700 text-white">
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
                <option value="staff">Staff</option>
            </select>
        </div>

        <button type="submit" class="mt-3 bg-blue-600 px-4 py-2 rounded text-white">
            Tambah User
        </button>
    </form>

    {{-- TABLE --}}
    <div class="bg-slate-800 rounded p-4">
        <table class="w-full text-white">
            <thead>
                <tr class="border-b border-slate-600">
                    <th class="p-2 text-left">Nama</th>
                    <th class="p-2 text-left">Email</th>
                    <th class="p-2 text-left">Role</th>
                    <th class="p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b border-slate-700">
                    <td class="p-2">{{ $user->name }}</td>
                    <td class="p-2">{{ $user->email }}</td>
                    <td class="p-2">{{ $user->role }}</td>
                    <td class="p-2 flex gap-2">
                        <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="button"
                                onclick="confirmDelete({{ $user->id }})"
                                class="bg-red-500 px-3 py-1 rounded text-white">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection

@push('scripts')
<script>
// 🔥 NOTIF SUCCESS & ERROR
document.addEventListener('DOMContentLoaded', function () {

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 1200,
        showConfirmButton: false
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '{{ session('error') }}',
        timer: 1500,
        showConfirmButton: false
    });
    @endif

});

// 🔥 CONFIRM DELETE
function confirmDelete(id) {
    Swal.fire({
        title: 'Yakin hapus?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endpush