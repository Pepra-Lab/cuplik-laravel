<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Video extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'link',
        'durasi',
        'dibaca',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'dibaca' => 'integer',
    ];

    public function getYoutubeIdAttribute(): ?string
    {
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $this->link, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->tanggal ? Carbon::parse($this->tanggal)->locale('id')->isoFormat('D MMMM Y') : '';
    }
}
