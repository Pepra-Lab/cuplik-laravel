<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class IklanBaris extends Model
{
    use BelongsToUser;

    protected $table = 'iklan_baris';

    protected $fillable = [
        'user_id',
        'pemasang',
        'kategori',
        'isi',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function getFormattedDateAttribute(): string
    {
        return $this->tanggal ? Carbon::parse($this->tanggal)->locale('id')->isoFormat('D MMMM Y') : '';
    }
}
