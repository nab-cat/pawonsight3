<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pemasukan extends Model
{
    protected $fillable = [
        'id_produk',
        'items',
        'jumlah_terjual',
        'harga_produk',
        'total_harga',
        'total_harga_keseluruhan',
        'kategori',
        'created_at',
    ];   

    protected $casts = [
        'items' => 'array',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
