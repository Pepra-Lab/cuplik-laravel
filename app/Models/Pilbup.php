<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pilbup extends Model
{
    protected $fillable = [
        'judul',
        'tahun',
        'status',
    ];

    public function paslons(): HasMany
    {
        return $this->hasMany(Paslon::class)->orderBy('no_urut');
    }

    public function dpts(): HasMany
    {
        return $this->hasMany(Dpt::class);
    }
}
