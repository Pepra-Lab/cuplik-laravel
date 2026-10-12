<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_SUPER_ADMIN = 'Super Admin';
    public const ROLE_ADMIN = 'Admin';
    public const ROLE_REDAKTUR = 'Redaktur';
    public const ROLE_MEMBER = 'Member';

    public const ROLES = [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN, self::ROLE_REDAKTUR, self::ROLE_MEMBER];
    public const MANAGER_ROLES = [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN];
    public const CONTRIBUTOR_ROLES = [self::ROLE_REDAKTUR, self::ROLE_MEMBER];

    public const STATUS_ACTIVE = 'Aktif';
    public const STATUS_PENDING = 'Menunggu';
    public const STATUS_REJECTED = 'Ditolak';
    public const ACCOUNT_STATUSES = ['Aktif', 'Nonaktif', 'Diblokir'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, self::MANAGER_ROLES, true);
    }

    public function isRedaktur(): bool
    {
        return $this->role === self::ROLE_REDAKTUR;
    }

    public function isMember(): bool
    {
        return $this->role === self::ROLE_MEMBER;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function canAccessCms(): bool
    {
        return in_array($this->role, self::ROLES, true);
    }

    /**
     * Admin, Super Admin, dan Redaktur mengelola konten portal (berita, video,
     * dsb). Member tidak termasuk di sini — jatahnya cuma mengirim iklan sendiri.
     */
    public function isCmsStaff(): bool
    {
        return $this->isAdmin() || $this->isRedaktur();
    }

    /**
     * Halaman CMS pertama yang dilihat sesuai perannya. Member diarahkan
     * langsung ke Iklan Saya karena tidak punya akses ke menu lain.
     */
    public function cmsHomeRoute(): string
    {
        return $this->isMember() ? 'admin.iklan-saya.index' : 'admin.dashboard';
    }

    /**
     * Akun Admin dan Super Admin hanya boleh diubah oleh Super Admin.
     */
    public function canBeManagedBy(User $actor): bool
    {
        return $actor->isSuperAdmin() || ! in_array($this->role, self::MANAGER_ROLES, true);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
