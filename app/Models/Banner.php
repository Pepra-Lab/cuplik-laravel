<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'judul',
        'gambar',
        'tautan',
        'urutan',
        'tampil',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];
}
