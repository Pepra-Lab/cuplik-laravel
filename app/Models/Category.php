<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'nama',
        'slug',
        'urutan',
        'tampil',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
