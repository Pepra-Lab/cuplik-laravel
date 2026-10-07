<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuaraPilbup extends Model
{
    protected $table = 'suara_pilbups';

    protected $fillable = [
        'dpt_id',
        'paslon_id',
        'suara',
    ];

    protected $casts = [
        'suara' => 'integer',
    ];

    public function dpt(): BelongsTo
    {
        return $this->belongsTo(Dpt::class);
    }

    public function paslon(): BelongsTo
    {
        return $this->belongsTo(Paslon::class);
    }
}
