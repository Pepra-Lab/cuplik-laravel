<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Article extends Model
{
    protected $fillable = [
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

    public function getFotoAttribute($value): ?string
    {
        if (!$value) return null;
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') || str_starts_with($value, '/')) {
            return $value;
        }
        return '/' . $value;
    }

    public function getFoto2Attribute($value): ?string
    {
        if (!$value) return null;
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') || str_starts_with($value, '/')) {
            return $value;
        }
        return '/' . $value;
    }

    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) return null;
        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            return $this->foto;
        }
        return asset(ltrim($this->foto, '/'));
    }

    public function getFoto2UrlAttribute(): ?string
    {
        if (!$this->foto_2) return null;
        if (str_starts_with($this->foto_2, 'http://') || str_starts_with($this->foto_2, 'https://')) {
            return $this->foto_2;
        }
        return asset(ltrim($this->foto_2, '/'));
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        $img = $this->foto ?: $this->foto_2;
        if (!$img) return null;
        if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
            return $img;
        }
        return asset($img);
    }

    /**
     * Generate ringkas slug dari judul (maksimal 5-6 kata inti, tanpa stopword Indonesia).
     */
    public static function generateConciseSlug(string $title, int $maxWords = 5): string
    {
        $clean = strip_tags($title);
        $clean = mb_strtolower($clean, 'UTF-8');
        // Ganti karakter non-alfanumerik dengan spasi
        $clean = preg_replace('/[^\p{L}\p{Nd}\s]/u', ' ', $clean);

        $rawWords = preg_split('/\s+/u', $clean, -1, PREG_SPLIT_NO_EMPTY);

        // Daftar stopword bahasa Indonesia umum
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
            'secara', 'bagi', 'terus', 'kembali', 'usai', 'pasca', 'bakal', 'kala', 'sejak'
        ];

        $filtered = array_values(array_filter($rawWords, function ($word) use ($stopwords) {
            return !in_array($word, $stopwords, true) && mb_strlen($word) > 1;
        }));

        if (empty($filtered)) {
            $filtered = $rawWords;
        }

        // Ambil 5-6 kata inti
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
        $baseSlug = Str::slug($slug);
        if ($baseSlug === '') {
            $baseSlug = 'berita';
        }

        $candidate = $baseSlug;
        $counter = 2;

        while (static::where('slug', $candidate)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
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

        // Cek tag <p> pertama
        if (preg_match('/<p[^>]*>(.*?)<\/p>/is', $content, $matches)) {
            $paragraph = trim(strip_tags($matches[1]));
        }

        // Jika belum dapat, cek pemisah baris baru ganda atau <br>
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

        // Fallback: seluruh teks yang di-strip tag
        if (empty($paragraph)) {
            $paragraph = trim(strip_tags($content));
        }

        // Normalisasi entitas HTML dan spasi berlebih
        $paragraph = html_entity_decode($paragraph, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $paragraph = preg_replace('/\s+/u', ' ', $paragraph);
        $paragraph = trim($paragraph);

        if (mb_strlen($paragraph) <= $maxLength) {
            return $paragraph;
        }

        // Potong di batas kata terakhir yang utuh dalam $maxLength karakter
        $truncated = mb_substr($paragraph, 0, $maxLength);
        $lastSpace = mb_strrpos($truncated, ' ');
        if ($lastSpace !== false && $lastSpace > 0) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }

        return rtrim($truncated, " ,.-;:!?") . '...';
    }

    /**
     * Render konten berita dengan gambar yang disisipkan sesuai posisi penempatan (p1, p2, p3, p4, p5, bottom).
     */
    public function renderContentWithImages(): string
    {
        $content = $this->isi;
        $inlines = [];

        // Gambar 1 jika posisinya bukan header
        if ($this->foto && $this->foto_posisi && $this->foto_posisi !== 'header') {
            $inlines[$this->foto_posisi][] = [
                'src' => $this->foto_url,
                'caption' => $this->caption_foto,
                'alt' => $this->judul . ' - Gambar 1',
            ];
        }

        // Gambar 2 jika posisinya bukan header
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

        // Pecah berdasarkan tag penutup </p>
        $paragraphs = preg_split('/(<\/p>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);

        if (count($paragraphs) <= 1) {
            // Teks biasa tanpa tag <p>
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
