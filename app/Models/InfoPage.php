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
     * Daftar halaman info yang tersedia untuk dikelola lewat CMS, berikut
     * label tab-nya. Dipakai untuk validasi slug di route/controller dan
     * untuk merender tab navigasi di halaman edit.
     */
    public const SLUGS = [
        'redaksi' => 'Susunan Redaksi',
        'pedoman' => 'Pedoman Media',
        'disclaimer' => 'Disclaimer',
        'iklan' => 'Info Iklan',
    ];

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
