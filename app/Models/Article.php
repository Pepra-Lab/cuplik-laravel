<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use App\Observers\ArticleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

#[ObservedBy(ArticleObserver::class)]
class Article extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'category_id',
        'editor_nama',
        'penulis_nama',
        'lokasi',
        'lead',
        'isi',
        'foto',
        'tone',
        'dibaca',
        'status',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'dibaca' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->tanggal ? Carbon::parse($this->tanggal)->locale('id')->isoFormat('D MMMM Y') : '';
    }

    public function getTimeAgoAttribute(): string
    {
        if (!$this->tanggal) return 'Baru saja';
        return Carbon::parse($this->tanggal)->locale('id')->diffForHumans();
    }
}
