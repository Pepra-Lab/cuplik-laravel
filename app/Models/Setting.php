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
    ];

    /**
     * Pengaturan situs disimpan sebagai satu baris tunggal (singleton).
     * Dipanggil lewat Setting::current() di mana saja perlu.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
