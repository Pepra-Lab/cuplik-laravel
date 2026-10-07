<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IklanGambar extends Model
{
    protected $fillable = [
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
