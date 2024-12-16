<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengeluaran extends Model
{
    protected $fillable = [
        'id',
        'nama_bahan',
        'harga_satuan',
        'total_pengeluaran',       
        'jumlah_pembelian',
        'tanggal_pembelian',
    ];   

    public function stokbahan()
    {
        return $this->belongsTo(Stokbahan::class, 'nama_bahan', 'id', 'jumlah_stok');
    }
}
