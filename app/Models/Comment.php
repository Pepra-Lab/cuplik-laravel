<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Comment extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'article_id',
        'nama',
        'email',
        'komentar',
        'status',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function getTimeAgoAttribute(): string
    {
        return Carbon::parse($this->created_at)->locale('id')->diffForHumans();
    }
}
