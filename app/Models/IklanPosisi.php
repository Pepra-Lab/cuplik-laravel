<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IklanPosisi extends Model
{
    protected $fillable = [
        'nama',
        'ukuran',
        'keterangan',
    ];

    /**
     * Iklan Gambar menyimpan posisi sebagai string (bukan foreign key),
     * relasi ini dicocokkan lewat nama posisi agar tetap nyambung ke data lama.
     */
    public function iklanGambars()
    {
        return $this->hasMany(IklanGambar::class, 'posisi', 'nama');
    }
}
