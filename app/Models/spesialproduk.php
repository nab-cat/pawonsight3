<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class spesialproduk extends Model
{
    protected $fillable = [
        'id_produk',
        'nama_produk',
        'deskripsi',
        'kategori',
        'harga',
        'stok',
        'gambar_produk',
    ];

     // Menentukan primary key yang berbeda
     protected $primaryKey = 'id_produk';

}
