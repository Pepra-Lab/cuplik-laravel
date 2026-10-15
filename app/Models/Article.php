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
        'foto_2',
        'foto_posisi',
        'foto_2_posisi',
        'caption_foto',
        'caption_foto_2',
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

        return $this->resolveImageUrl($image);
    }

    /**
     * Ubah path gambar lokal (mis. "berita/foto.jpg") atau URL eksternal
     * menjadi URL lengkap yang bisa diakses browser.
     */
    private function resolveImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])
            ? $path
            : asset($path);
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->foto);
    }

    public function getFoto2UrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->foto_2);
    }

    /**
     * Generate ringkas slug dari judul (maksimal 5-6 kata inti, tanpa stopword Indonesia).
     * Dipakai oleh fitur unduh PDF & bisa dipakai juga saat slug dikosongkan di form admin.
     */
    public static function generateConciseSlug(string $title, int $maxWords = 5): string
    {
        $clean = strip_tags($title);
        $clean = mb_strtolower($clean, 'UTF-8');
        $clean = preg_replace('/[^\p{L}\p{Nd}\s]/u', ' ', $clean);

        $rawWords = preg_split('/\s+/u', $clean, -1, PREG_SPLIT_NO_EMPTY);

        $stopwords = [
            'yang', 'di', 'ke', 'dari', 'dan', 'ini', 'itu', 'untuk', 'dengan', 'pada',
            'adalah', 'sebagai', 'dalam', 'oleh', 'atau', 'jika', 'maka', 'akan', 'sudah',
            'telah', 'sedang', 'ada', 'tidak', 'tak', 'bukan', 'bisa', 'dapat', 'lebih',
            'sangat', 'juga', 'serta', 'karena', 'agar', 'supaya', 'hingga', 'sampai',
            'saat', 'ketika', 'tentang', 'menurut', 'atas', 'bawah', 'antar', 'antara',
            'baru', 'mulai', 'resmi', 'jadi', 'menjadi', 'hari', 'besok', 'kemarin',
            'para', 'suatu', 'satu', 'dua', 'tiga', 'tersebut', 'lagi', 'masih', 'pun',
            'si', 'sang', 'ia', 'dia', 'mereka', 'kita', 'kami', 'kamu', 'anda', 'kalian',
            'lalu', 'kemudian', 'namun', 'tetapi', 'melainkan', 'hanya', 'saja', 'punya',
            'bila', 'apabila', 'seperti', 'bagai', 'bagaikan', 'yakni', 'yaitu', 'terhadap',
            'secara', 'bagi', 'terus', 'kembali', 'usai', 'pasca', 'bakal', 'kala', 'sejak',
        ];

        $filtered = array_values(array_filter($rawWords, function ($word) use ($stopwords) {
            return !in_array($word, $stopwords, true) && mb_strlen($word) > 1;
        }));

        if (empty($filtered)) {
            $filtered = $rawWords;
        }

        $limit = min(max($maxWords, 5), 6);
        $selected = array_slice($filtered, 0, $limit);

        $slug = implode('-', $selected);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        return $slug ?: 'berita';
    }

    /**
     * Pastikan slug unik dengan menambahkan suffix (-2, -3, dst).
     */
    public static function generateUniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $baseSlug = \Illuminate\Support\Str::slug($slug);
        if ($baseSlug === '') {
            $baseSlug = 'berita';
        }

        $candidate = $baseSlug;
        $counter = 2;

        while (static::where('slug', $candidate)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $candidate = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $candidate;
    }

    /**
     * Ambil otomatis lead dari paragraf pertama isi berita (maksimal 500 karakter).
     */
    public static function generateLead(string $content, int $maxLength = 500): string
    {
        if (empty(trim($content))) {
            return '';
        }

        $paragraph = '';

        if (preg_match('/<p[^>]*>(.*?)<\/p>/is', $content, $matches)) {
            $paragraph = trim(strip_tags($matches[1]));
        }

        if (empty($paragraph)) {
            $parts = preg_split('/(<br\s*\/?>|\r\n\r\n|\n\n|\r\r)/i', $content);
            if (!empty($parts)) {
                foreach ($parts as $part) {
                    $cleaned = trim(strip_tags($part));
                    if (!empty($cleaned)) {
                        $paragraph = $cleaned;
                        break;
                    }
                }
            }
        }

        if (empty($paragraph)) {
            $paragraph = trim(strip_tags($content));
        }

        $paragraph = html_entity_decode($paragraph, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $paragraph = preg_replace('/\s+/u', ' ', $paragraph);
        $paragraph = trim($paragraph);

        if (mb_strlen($paragraph) <= $maxLength) {
            return $paragraph;
        }

        $truncated = mb_substr($paragraph, 0, $maxLength);
        $lastSpace = mb_strrpos($truncated, ' ');
        if ($lastSpace !== false && $lastSpace > 0) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }

        return rtrim($truncated, " ,.-;:!?") . '...';
    }

    /**
     * Render konten berita dengan gambar yang disisipkan sesuai posisi penempatan
     * (p1, p2, p3, p4, p5, bottom). Dipakai oleh fitur unduh PDF.
     */
    public function renderContentWithImages(): string
    {
        $content = $this->isi;
        $inlines = [];

        if ($this->foto && $this->foto_posisi && $this->foto_posisi !== 'header') {
            $inlines[$this->foto_posisi][] = [
                'src' => $this->foto_url,
                'caption' => $this->caption_foto,
                'alt' => $this->judul . ' - Gambar 1',
            ];
        }

        if ($this->foto_2 && $this->foto_2_posisi && $this->foto_2_posisi !== 'header') {
            $inlines[$this->foto_2_posisi][] = [
                'src' => $this->foto_2_url,
                'caption' => $this->caption_foto_2,
                'alt' => $this->judul . ' - Gambar 2',
            ];
        }

        if (empty($inlines)) {
            return $content;
        }

        $paragraphs = preg_split('/(<\/p>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);

        if (count($paragraphs) <= 1) {
            $lines = preg_split('/(\r\n\r\n|\n\n)/', $content);
            $result = '';
            foreach ($lines as $index => $para) {
                $pNum = 'p' . ($index + 1);
                $result .= '<p>' . nl2br(trim($para)) . '</p>';
                if (isset($inlines[$pNum])) {
                    foreach ($inlines[$pNum] as $img) {
                        $result .= $this->buildImageHtml($img);
                    }
                }
            }
            if (isset($inlines['bottom'])) {
                foreach ($inlines['bottom'] as $img) {
                    $result .= $this->buildImageHtml($img);
                }
            }
            return $result;
        }

        $result = '';
        $pCount = 0;
        for ($i = 0; $i < count($paragraphs); $i++) {
            $chunk = $paragraphs[$i];
            $result .= $chunk;

            if (strcasecmp($chunk, '</p>') === 0) {
                $pCount++;
                $pKey = 'p' . $pCount;
                if (isset($inlines[$pKey])) {
                    foreach ($inlines[$pKey] as $img) {
                        $result .= $this->buildImageHtml($img);
                    }
                }
            }
        }

        if (isset($inlines['bottom'])) {
            foreach ($inlines['bottom'] as $img) {
                $result .= $this->buildImageHtml($img);
            }
        }

        return $result;
    }

    private function buildImageHtml(array $img): string
    {
        $captionHtml = '';
        if (!empty($img['caption'])) {
            $captionHtml = '<figcaption class="text-[11px] text-gray-500 dark:text-gray-400 italic text-center mt-2 px-2">' . e($img['caption']) . '</figcaption>';
        }

        return '<figure class="my-6 max-w-lg mx-auto text-center">' .
               '<div class="img-zoom-wrap aspect-[16/10] max-h-64 sm:max-h-72 rounded-none overflow-hidden mx-auto shadow-sm">' .
               '<img src="' . e($img['src']) . '" alt="' . e($img['alt']) . '" class="w-full h-full object-cover mx-auto rounded-none">' .
               '</div>' .
               $captionHtml .
               '</figure>';
    }
}
