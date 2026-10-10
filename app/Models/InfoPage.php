<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoPage extends Model
{
    protected $fillable = [
        'slug',
        'badge',
        'judul',
        'subjudul',
        'konten',
    ];

    /**
     * Daftar halaman info yang tersedia untuk dikelola lewat CMS.
     * Dipakai juga untuk validasi slug di route dan controller.
     */
    public const SLUGS = ['redaksi', 'pedoman', 'disclaimer', 'iklan'];

    /**
     * Ambil satu halaman berdasarkan slug. Dibuatkan baris kosong bila
     * belum pernah diisi sama sekali, supaya form edit tidak pernah 404.
     */
    public static function olehSlug(string $slug): self
    {
        return static::firstOrCreate(
            ['slug' => $slug],
            ['judul' => ucfirst($slug), 'konten' => '']
        );
    }
}
