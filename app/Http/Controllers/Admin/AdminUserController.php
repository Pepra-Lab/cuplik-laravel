<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    private const TABS = [
        'pengelola' => ['label' => 'Pengelola', 'subtitle' => 'Pengelola CMS: Admin dan Super Admin'],
        'redaktur' => ['label' => 'Redaktur', 'subtitle' => 'Mengelola berita dan video dari akunnya sendiri'],
        'member' => ['label' => 'Member', 'subtitle' => 'Mengirim berita untuk ditinjau admin'],
        'verifikasi' => ['label' => 'Verifikasi', 'subtitle' => 'Setujui atau tolak akun yang baru mendaftar'],
    ];

    private const SORTABLE = ['name', 'email', 'role', 'status', 'created_at'];
    private const PER_PAGE = [10, 25, 50];

    public function index(Request $request): View
    {
        $tab = array_key_exists($request->query('tab'), self::TABS) ? $request->query('tab') : 'pengelola';
        $q = trim($request->query('q', ''));
        $filter = $request->query('filter', $tab === 'verifikasi' ? User::STATUS_PENDING : '');
        $sort = in_array($request->query('sort'), self::SORTABLE, true) ? $request->query('sort') : 'created_at';
        $dir = $request->query('dir') === 'asc' ? 'asc' : 'desc';
        $perPage = in_array((int) $request->query('per_page'), self::PER_PAGE, true) ? (int) $request->query('per_page') : 10;

        $query = User::query();
        $pendingStatuses = [User::STATUS_PENDING, User::STATUS_REJECTED];

        if ($tab === 'verifikasi') {
            $query->whereIn('status', $pendingStatuses);
            if ($filter !== 'Semua') {
                $query->where('status', $filter);
            }
        } else {
            $query->whereNotIn('status', $pendingStatuses)->whereIn('role', $this->rolesForTab($tab));
            if ($filter !== '') {
                $query->where($tab === 'pengelola' ? 'role' : 'status', $filter);
            }
        }

        if ($q !== '') {
            $query->where(fn ($sub) => $sub
                ->where('name', 'ilike', "%{$q}%")
                ->orWhere('email', 'ilike', "%{$q}%"));
        }

        $users = $query->orderBy($sort, $dir)->paginate($perPage)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'tabs' => self::TABS,
            'tab' => $tab,
            'q' => $q,
            'filter' => $filter,
            'sort' => $sort,
            'dir' => $dir,
            'perPage' => $perPage,
            'perPageOptions' => self::PER_PAGE,
            'roleOptions' => $tab === 'pengelola' ? User::MANAGER_ROLES : User::CONTRIBUTOR_ROLES,
            'pendingCount' => User::where('status', User::STATUS_PENDING)->count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(User::ROLES)],
            'status' => ['required', Rule::in(User::ACCOUNT_STATUSES)],
        ]);

        $this->ensureCanAssign($request->user(), $data['role']);

        User::create($data);

        return $this->backToTab($data['role'], 'Pengguna berhasil ditambahkan!');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $actor = $request->user();
        abort_unless($user->canBeManagedBy($actor), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => ['required', Rule::in(User::ROLES)],
            'status' => ['required', Rule::in(User::ACCOUNT_STATUSES)],
        ]);

        $this->ensureCanAssign($actor, $data['role']);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        // Peran dan status akun sendiri tidak boleh diubah dari halaman ini.
        if ($user->is($actor)) {
            unset($data['role'], $data['status']);
        }

        $user->update($data);

        return $this->backToTab($user->role, 'Pengguna berhasil diperbarui!');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        abort_unless($user->canBeManagedBy($request->user()), 403);

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus!');
    }

    public function approve(User $user): RedirectResponse
    {
        $user->update(['status' => User::STATUS_ACTIVE]);

        return back()->with('success', "Akun {$user->email} disetujui.");
    }

    public function reject(User $user): RedirectResponse
    {
        $user->update(['status' => User::STATUS_REJECTED]);

        return back()->with('success', "Akun {$user->email} ditolak.");
    }

    private function rolesForTab(string $tab): array
    {
        return match ($tab) {
            'pengelola' => User::MANAGER_ROLES,
            'redaktur' => [User::ROLE_REDAKTUR],
            default => [User::ROLE_MEMBER],
        };
    }

    private function ensureCanAssign(User $actor, string $role): void
    {
        abort_if(in_array($role, User::MANAGER_ROLES, true) && ! $actor->isSuperAdmin(), 403);
    }

    private function backToTab(string $role, string $message): RedirectResponse
    {
        $tab = match (true) {
            in_array($role, User::MANAGER_ROLES, true) => 'pengelola',
            $role === User::ROLE_REDAKTUR => 'redaktur',
            default => 'member',
        };

        return redirect()->route('admin.users.index', ['tab' => $tab])->with('success', $message);
    }
}
