<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IklanKategori extends Model
{
    protected $fillable = [
        'nama',
    ];

    /**
     * Iklan Baris menyimpan kategori sebagai string (bukan foreign key),
     * relasi ini dicocokkan lewat nama kategori agar tetap nyambung ke data lama.
     */
    public function iklanBaris()
    {
        return $this->hasMany(IklanBaris::class, 'kategori', 'nama');
    }
}
