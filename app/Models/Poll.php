<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poll extends Model
{
    protected $fillable = [
        'pertanyaan',
        'status',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(PollOption::class)->orderBy('urutan')->orderBy('id');
    }

    public function getTotalVotesAttribute(): int
    {
        return $this->options->sum('suara');
    }
}
