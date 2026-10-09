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
}
