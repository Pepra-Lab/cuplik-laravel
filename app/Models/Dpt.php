<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dpt extends Model
{
    protected $fillable = [
        'pilbup_id',
        'kecamatan',
        'desa',
        'tps',
        'dpt',
        'dpph',
        'dptb',
        'ts',
    ];

    protected $casts = [
        'tps' => 'integer',
        'dpt' => 'integer',
        'dpph' => 'integer',
        'dptb' => 'integer',
        'ts' => 'integer',
    ];

    public function pilbup(): BelongsTo
    {
        return $this->belongsTo(Pilbup::class);
    }

    public function suara(): HasMany
    {
        return $this->hasMany(SuaraPilbup::class);
    }
}
