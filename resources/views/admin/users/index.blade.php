@extends('layouts.admin')

@use('App\Models\User')

@section('title', 'Pengguna')

@php
    $actor = auth()->user();
    $isVerification = $tab === 'verifikasi';
    $canAdd = !$isVerification && ($tab !== 'pengelola' || $actor->isSuperAdmin());

    $filterOptions = match (true) {
        $tab === 'pengelola' => User::MANAGER_ROLES,
        $isVerification => [User::STATUS_PENDING, User::STATUS_REJECTED, 'Semua'],
        default => User::ACCOUNT_STATUSES,
    };

    $columns = match ($tab) {
        'pengelola' => ['name' => 'Nama', 'email' => 'Email', 'role' => 'Peran', 'status' => 'Status'],
        'verifikasi' => ['name' => 'Nama', 'email' => 'Email', 'role' => 'Mendaftar sebagai', 'created_at' => 'Tanggal', 'status' => 'Status'],
        default => ['name' => 'Nama', 'email' => 'Email', 'created_at' => 'Terdaftar', 'status' => 'Status'],
    };

    $badgeClass = [
        'Aktif' => 'badge-status-ok',
        'Nonaktif' => 'badge-status-wt',
        'Menunggu' => 'badge-status-wt',
        'Diblokir' => 'badge-status-no',
        'Ditolak' => 'badge-status-no',
    ];

    $sortUrl = fn(string $column) => route('admin.users.index', array_merge(request()->query(), [
        'sort' => $column,
        'dir' => $sort === $column && $dir === 'asc' ? 'desc' : 'asc',
        'page' => null,
    ]));

    $inputClass = 'w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]';
    $actionClass = 'px-2 py-1 text-xs font-semibold bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700';

    // Data lama untuk membuka kembali modal jika validasi gagal.
    $oldUserData = [
        'id' => old('_id'),
        'name' => old('name'),
        'email' => old('email'),
        'role' => old('role'),
        'status' => old('status'),
    ];
@endphp

@section('content')
    <div class="space-y-5">

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-extrabold text-gray-900 dark:text-white">Pengguna</h2>
                <p class="text-xs text-gray-400">{{ $tabs[$tab]['subtitle'] }}</p>
            </div>

            @if($canAdd)
                <button type="button" onclick="openUserModal()"
                    class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                    Tambah Data
                </button>
            @endif
        </div>

        <!-- Tabs -->
        <div class="flex gap-1 border-b border-gray-200 dark:border-zinc-800 overflow-x-auto">
            @foreach($tabs as $key => $item)
                <a href="{{ route('admin.users.index', ['tab' => $key]) }}"
                    class="px-4 py-2.5 text-xs font-bold whitespace-nowrap border-b-2 -mb-px transition-colors {{ $tab === $key ? 'border-[#008a24] text-[#008a24]' : 'border-transparent text-gray-500 hover:text-gray-900 dark:hover:text-white' }}">
                    {{ $item['label'] }}
                    @if($key === 'verifikasi' && $pendingCount > 0)
                        <span class="ml-1.5 bg-red-600 text-white text-[10px] rounded-full px-1.5 py-0.5">{{ $pendingCount }}</span>
                    @endif
                </a>
            @endforeach
        </div>

        <div
            class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">

            <!-- Toolbar -->
            <form method="GET" action="{{ route('admin.users.index') }}"
                class="p-4 flex flex-wrap items-center gap-3 border-b border-gray-200 dark:border-zinc-800">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <input type="hidden" name="dir" value="{{ $dir }}">

                <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama atau email..."
                    class="flex-1 min-w-[200px] px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-[#008a24]">

                <select name="filter" onchange="this.form.submit()"
                    class="px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs">
                    @unless($isVerification)
                        <option value="">{{ $tab === 'pengelola' ? 'Semua peran' : 'Semua status' }}</option>
                    @endunless
                    @foreach($filterOptions as $option)
                        <option value="{{ $option }}" @selected($filter === $option)>{{ $option }}</option>
                    @endforeach
                </select>

                <select name="per_page" onchange="this.form.submit()"
                    class="px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs">
                    @foreach($perPageOptions as $size)
                        <option value="{{ $size }}" @selected($perPage === $size)>{{ $size }} / halaman</option>
                    @endforeach
                </select>
            </form>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead
                        class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                        <tr>
                            @foreach($columns as $column => $label)
                                <th class="px-4 py-3">
                                    <a href="{{ $sortUrl($column) }}"
                                        class="inline-flex items-center gap-1 hover:text-[#008a24]">
                                        {{ $label }}
                                        @if($sort === $column)
                                            <span>{{ $dir === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                            @endforeach
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($users as $u)
                            @php
                                $isSelf = $u->is($actor);
                                $manageable = $u->canBeManagedBy($actor);
                                $payload = ['id' => $u->id, 'name' => $u->name, 'email' => $u->email, 'role' => $u->role, 'status' => $u->status, 'self' => $isSelf];
                            @endphp
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">
                                    {{ $u->name }}
                                    @if($isSelf)
                                        <span
                                            class="ml-1 text-[9px] bg-emerald-100 dark:bg-emerald-950 text-[#008a24] px-1.5 py-0.5 rounded font-bold">Anda</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $u->email }}</td>
                                @if(isset($columns['role']))
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $u->role }}</td>
                                @endif
                                @if(isset($columns['created_at']))
                                    <td class="px-4 py-3 text-gray-400 whitespace-nowrap">{{ $u->created_at?->format('d/m/Y') }}
                                    </td>
                                @endif
                                <td class="px-4 py-3"><span
                                        class="{{ $badgeClass[$u->status] ?? 'badge-status-wt' }}">{{ $u->status }}</span></td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if($isVerification)
                                            @if($u->status !== User::STATUS_ACTIVE)
                                                <form action="{{ route('admin.users.approve', $u) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="{{ $actionClass }} text-[#008a24]">Setujui</button>
                                                </form>
                                            @endif
                                            @if($u->status === User::STATUS_PENDING)
                                                <form action="{{ route('admin.users.reject', $u) }}" method="POST"
                                                    onsubmit="return confirm('Tolak akun {{ $u->email }}?')">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="{{ $actionClass }} text-amber-600">Tolak</button>
                                                </form>
                                            @endif
                                        @elseif($manageable)
                                            <button type="button" data-user="{{ json_encode($payload) }}"
                                                onclick="openUserModal(JSON.parse(this.dataset.user))"
                                                class="{{ $actionClass }} text-gray-700 dark:text-gray-300 hover:text-[#008a24]">Ubah</button>
                                        @endif

                                        @if($manageable && !$isSelf)
                                            <form action="{{ route('admin.users.destroy', $u) }}" method="POST"
                                                onsubmit="return confirm('Hapus pengguna {{ $u->email }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="{{ $actionClass }} text-red-500 hover:text-red-700">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) + 1 }}" class="px-4 py-8 text-center text-gray-400">Tidak ada
                                    data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                class="p-4 border-t border-gray-200 dark:border-zinc-800 flex items-center justify-between text-xs text-gray-500">
                <span>Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} dari
                    {{ $users->total() }}</span>
                <div class="flex gap-2">
                    @foreach(['Sebelumnya' => $users->previousPageUrl(), 'Berikutnya' => $users->nextPageUrl()] as $label => $url)
                        @if($url)
                            <a href="{{ $url }}"
                                class="{{ $actionClass }} text-gray-700 dark:text-gray-300 hover:text-[#008a24]">{{ $label }}</a>
                        @else
                            <span class="{{ $actionClass }} text-gray-300 dark:text-zinc-600 cursor-not-allowed">{{ $label }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah / Ubah -->
    <div id="userModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
        <div
            class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-xl max-w-md w-full p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-3">
                <h3 id="userModalTitle" class="text-sm font-bold text-gray-900 dark:text-white"></h3>
                <button type="button" onclick="closeUserModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>

            @if($errors->any() && old('_form') === 'user')
                <div
                    class="bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 p-3 rounded-lg text-xs space-y-0.5">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form id="userForm" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="userMethod" value="PUT" disabled>
                <input type="hidden" name="_form" value="user">
                <input type="hidden" name="_id" id="userId">

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama</label>
                    <input type="text" name="name" id="userName" required class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input type="email" name="email" id="userEmail" required class="{{ $inputClass }}">
                </div>

                <div>
                    <label id="userPasswordLabel"
                        class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1"></label>
                    <input type="password" name="password" id="userPassword" minlength="8" autocomplete="new-password"
                        class="{{ $inputClass }}">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Peran</label>
                        <select name="role" id="userRole" class="{{ $inputClass }}">
                            @foreach($roleOptions as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" id="userStatus" class="{{ $inputClass }}">
                            @foreach(User::ACCOUNT_STATUSES as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <p id="userSelfNote" class="hidden text-[11px] text-gray-400">Peran dan status akun Anda sendiri tidak dapat
                    diubah di sini.</p>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeUserModal()"
                        class="px-4 py-2 bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-bold">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white rounded-lg text-xs font-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const userModal = document.getElementById('userModal');
            const userForm = document.getElementById('userForm');
            const usersUrl = @json(route('admin.users.index'));
            const defaultRole = @json($roleOptions[0]);

            function openUserModal(user = null) {
                const isEdit = user && user.id;

                document.getElementById('userModalTitle').textContent = isEdit ? 'Ubah Pengguna' : 'Tambah Pengguna';
                document.getElementById('userPasswordLabel').textContent = isEdit ? 'Kata Sandi Baru (kosongkan jika tidak diubah)' : 'Kata Sandi';
                document.getElementById('userPassword').required = !isEdit;

                userForm.action = isEdit ? `${usersUrl}/${user.id}` : usersUrl;
                document.getElementById('userMethod').disabled = !isEdit;
                document.getElementById('userId').value = isEdit ? user.id : '';

                document.getElementById('userName').value = user?.name ?? '';
                document.getElementById('userEmail').value = user?.email ?? '';
                document.getElementById('userPassword').value = '';
                document.getElementById('userRole').value = user?.role ?? defaultRole;
                document.getElementById('userStatus').value = user?.status ?? 'Aktif';

                const isSelf = Boolean(user?.self);
                document.getElementById('userRole').disabled = isSelf;
                document.getElementById('userStatus').disabled = isSelf;
                document.getElementById('userSelfNote').classList.toggle('hidden', !isSelf);

                userModal.classList.remove('hidden');
                userModal.classList.add('flex');
            }

            function closeUserModal() {
                userModal.classList.add('hidden');
                userModal.classList.remove('flex');
            }

            @if ($errors->any() && old('_form') === 'user')
                openUserModal({!! \Illuminate\Support\Js::from($oldUserData) !!});
            @endif

        </script>
    @endpush
@endsection