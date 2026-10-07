<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paslon extends Model
{
    protected $fillable = [
        'pilbup_id',
        'no_urut',
        'nama',
        'usungan',
        'warna',
        'foto',
    ];

    protected $casts = [
        'no_urut' => 'integer',
    ];

    public function pilbup(): BelongsTo
    {
        return $this->belongsTo(Pilbup::class);
    }

    public function suaraList(): HasMany
    {
        return $this->hasMany(SuaraPilbup::class);
    }
}
