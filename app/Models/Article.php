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
        'meta_title',
        'meta_description',
        'meta_image',
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

    /**
     * SEO: judul <title> & og:title. Pakai meta_title kalau diisi admin,
     * kalau tidak jatuh balik ke judul berita.
     */
    public function seoTitle(): string
    {
        return $this->meta_title ?: $this->judul;
    }

    /**
     * SEO: meta description & og:description. Pakai meta_description kalau
     * diisi, kalau tidak diambil otomatis dari lead/isi berita (dipotong 160 karakter).
     */
    public function seoDescription(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }

        $source = $this->lead ?: $this->isi;
        return \Illuminate\Support\Str::limit(trim(strip_tags($source)), 160, '');
    }

    /**
     * SEO: og:image & twitter:image. Pakai meta_image kalau diisi,
     * kalau tidak jatuh balik ke foto utama berita.
     */
    public function seoImage(): ?string
    {
        $image = $this->meta_image ?: $this->foto;

        if (!$image) {
            return null;
        }

        return \Illuminate\Support\Str::startsWith($image, ['http://', 'https://'])
            ? $image
            : asset($image);
    }
}
