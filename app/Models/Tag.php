<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = [
        'nama',
        'slug',
        'category_id',
        'sub_tampil',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_tag');
    }

    /**
     * Cari tag berdasarkan nama (dicocokkan lewat slug, case-insensitive),
     * atau buat baru jika belum ada. Dipakai saat Redaktur/Admin menambahkan
     * tag langsung dari form berita, supaya "Pilkada" dan "pilkada" tetap
     * jadi satu baris tag yang sama alih-alih dua tag yang mirip dan bentrok.
     *
     * Tag baru dibuat tanpa kategori dan tidak langsung tampil sebagai
     * submenu publik (sub_tampil = 'Tidak') — kurasi taksonomi (gabung
     * duplikat, set kategori, tampilkan di submenu) tetap jadi wewenang
     * Admin/Super Admin lewat menu Tag & Submenu.
     */
    public static function findOrCreateByName(string $nama): self
    {
        $nama = trim(preg_replace('/\s+/', ' ', $nama));
        $slug = Str::slug($nama);

        try {
            return static::firstOrCreate(
                ['slug' => $slug],
                ['nama' => $nama, 'sub_tampil' => 'Tidak']
            );
        } catch (QueryException $e) {
            // Dua pengguna mengirim tag baru yang sama nyaris bersamaan —
            // constraint unik pada kolom slug menolak salah satunya.
            // Ambil baris yang sudah lebih dulu berhasil dibuat, jangan dobel.
            return static::where('slug', $slug)->firstOrFail();
        }
    }
}
