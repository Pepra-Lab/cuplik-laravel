<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Curhat extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'pengirim',
        'lokasi',
        'pesan',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function getTimeAgoAttribute(): string
    {
        if (!$this->tanggal) return 'Baru saja';
        return Carbon::parse($this->tanggal)->locale('id')->diffForHumans();
    }
}
