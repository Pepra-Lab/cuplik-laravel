<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'deskripsi',
        'logo',
        'favicon',
        'alamat',
        'email',
        'telepon',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'footer_text',
        'notifikasi_artikel_aktif',
    ];

    protected $casts = [
        'notifikasi_artikel_aktif' => 'boolean',
    ];

    /**
     * Bersihkan HTML footer_text sebelum disimpan — field ini dirender raw
     * lewat {!! !!} di layout utama, jadi perlu disaring (defense-in-depth).
     */
    public function setFooterTextAttribute(?string $value): void
    {
        $this->attributes['footer_text'] = \App\Support\HtmlSanitizer::clean($value);
    }

    /**
     * Pengaturan situs disimpan sebagai satu baris tunggal (singleton).
     * Dipanggil lewat Setting::current() di mana saja perlu.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
