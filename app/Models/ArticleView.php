<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleView extends Model
{
    use MassPrunable;

    /** Satu pembaca (IP + perangkat) dihitung ulang setelah berapa jam. */
    public const WINDOW_HOURS = 24;

    public $timestamps = false;

    protected $fillable = [
        'article_id',
        'device_hash',
        'viewed_at',
        'created_at',
    ];

    protected $casts = [
        'viewed_at'  => 'datetime',
        'created_at' => 'datetime',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Baris yang sudah lewat 24 jam aman dihapus: pembaca itu memang
     * sudah boleh dihitung lagi, jadi tabel tidak membengkak.
     * Dijalankan lewat `model:prune` (dijadwalkan harian di routes/console.php).
     */
    public function prunable(): Builder
    {
        return static::where('viewed_at', '<=', now()->subHours(self::WINDOW_HOURS));
    }
}
