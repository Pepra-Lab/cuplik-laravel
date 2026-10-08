@extends('layouts.admin')

@section('title', 'Manajemen Pengguna & Redaksi')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Form Tambah Pengguna (1 Col) -->
    <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit space-y-4">
        <div>
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Tambah Pengguna Baru</h2>
            <p class="text-xs text-gray-400">Daftarkan akun staf redaksi, editor, penulis, atau admin</p>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="Nama lengkap staf / pengguna" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                @error('name') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" required placeholder="email@cuplik.com" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                @error('email') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kata Sandi <span class="text-red-500">*</span></label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                @error('password') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Peran (Role) <span class="text-red-500">*</span></label>
                    <select name="role" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        <option value="Admin">Admin</option>
                        <option value="Editor">Editor</option>
                        <option value="Penulis">Penulis</option>
                        <option value="Reporter">Reporter</option>
                        <option value="Redaksi">Redaksi</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Member">Member</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status Akun</label>
                    <select name="status" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                        <option value="Diblokir">Diblokir</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm flex items-center justify-center gap-2">
                Daftarkan Pengguna
            </button>
        </form>
    </div>

    <!-- Tabel Daftar Pengguna (2 Cols) -->
    <div class="lg:col-span-2 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden flex flex-col">
        <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Daftar Pengguna & Staf</h2>
            
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama atau email..." class="px-3 py-1.5 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none">
                <select name="role" class="px-2 py-1.5 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none">
                    <option value="">Semua Peran</option>
                    <option value="Super Admin" {{ $role === 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="Admin" {{ $role === 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Editor" {{ $role === 'Editor' ? 'selected' : '' }}>Editor</option>
                    <option value="Penulis" {{ $role === 'Penulis' ? 'selected' : '' }}>Penulis</option>
                    <option value="Reporter" {{ $role === 'Reporter' ? 'selected' : '' }}>Reporter</option>
                    <option value="Member" {{ $role === 'Member' ? 'selected' : '' }}>Member</option>
                </select>
                <button type="submit" class="px-3 py-1.5 bg-gray-900 dark:bg-zinc-700 text-white rounded-lg text-xs font-bold">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto flex-1">
            <table class="w-full text-xs text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3">Nama Pengguna</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Peran / Role</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3">Bergabung</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @forelse($users as $u)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-4 py-3 font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-[#008a24] text-white flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ substr($u->name, 0, 1) }}
                                </div>
                                <span class="truncate">{{ $u->name }}</span>
                                @if(auth()->id() === $u->id)
                                    <span class="text-[9px] bg-emerald-100 dark:bg-emerald-950 text-[#008a24] px-1.5 py-0.5 rounded font-bold">Anda</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500 font-mono text-[11px]">
                                {{ $u->email }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold 
                                    @if(in_array($u->role, ['Super Admin', 'Admin'])) bg-purple-50 dark:bg-purple-950 text-purple-600
                                    @elseif(in_array($u->role, ['Editor', 'Redaksi'])) bg-emerald-50 dark:bg-emerald-950 text-[#008a24]
                                    @elseif(in_array($u->role, ['Penulis', 'Reporter'])) bg-blue-50 dark:bg-blue-950 text-blue-600
                                    @else bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300
                                    @endif">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($u->status === 'Aktif')
                                    <span class="badge-status-ok">Aktif</span>
                                @elseif($u->status === 'Nonaktif')
                                    <span class="badge-status-wt">Nonaktif</span>
                                @else
                                    <span class="badge-status-no">Diblokir</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-400 whitespace-nowrap">
                                {{ $u->created_at ? $u->created_at->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="openEditUserModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ addslashes($u->email) }}', '{{ $u->role }}', '{{ $u->status }}')" class="px-2 py-1 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:text-[#008a24] bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Edit Pengguna">
                                        Edit
                                    </button>
                                    @if(auth()->id() !== $u->id)
                                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus pengguna {{ addslashes($u->name) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2 py-1 text-xs font-semibold text-red-500 hover:text-red-700 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Hapus Pengguna">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada pengguna terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-gray-200 dark:border-zinc-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-xl max-w-md w-full p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Edit Pengguna</h3>
            <button onclick="closeEditUserModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>

        <form id="editUserForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                <input type="text" id="editUserName" name="name" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Alamat Email</label>
                <input type="email" id="editUserEmail" name="email" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kata Sandi Baru (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" placeholder="Biarkan kosong jika tidak ganti sandi" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Peran (Role)</label>
                    <select id="editUserRole" name="role" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        <option value="Admin">Admin</option>
                        <option value="Editor">Editor</option>
                        <option value="Penulis">Penulis</option>
                        <option value="Reporter">Reporter</option>
                        <option value="Redaksi">Redaksi</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Member">Member</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select id="editUserStatus" name="status" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                        <option value="Diblokir">Diblokir</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditUserModal()" class="px-4 py-2 bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-bold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white rounded-lg text-xs font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditUserModal(id, name, email, role, status) {
        const modal = document.getElementById('editUserModal');
        const form = document.getElementById('editUserForm');
        form.action = `/admin/users/${id}`;
        document.getElementById('editUserName').value = name;
        document.getElementById('editUserEmail').value = email;
        document.getElementById('editUserRole').value = role;
        document.getElementById('editUserStatus').value = status;
        modal.classList.remove('hidden');
    }

    function closeEditUserModal() {
        document.getElementById('editUserModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
