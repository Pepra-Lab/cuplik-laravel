<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class IklanGambar extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'judul',
        'posisi',
        'ukuran',
        'link',
        'gambar',
        'mulai',
        'selesai',
        'status',
    ];

    protected $casts = [
        'mulai' => 'date',
        'selesai' => 'date',
    ];

    /**
     * Scope untuk hanya mengambil iklan gambar yang aktif tayang:
     * Status 'Tayang' dan berada dalam rentang tanggal mulai & selesai.
     */
    public function scopeActive($query)
    {
        $today = now()->toDateString();

        return $query->where('status', 'Tayang')
            ->where(function ($q) use ($today) {
                $q->whereNull('mulai')->orWhereDate('mulai', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('selesai')->orWhereDate('selesai', '>=', $today);
            });
    }
}
