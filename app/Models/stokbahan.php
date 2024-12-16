<?php

namespace App\Models;

use App\Observers\StokBahanObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
#[ObservedBy([StokBahanObserver::class])]

class stokbahan extends Model
{
    protected $fillable = [
        'nama_bahan',
        'kategori',
        'jumlah_stok',
        'minimum_stok',
        'satuan',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'harga_satuan',
        'status_kadaluarsa',
        'kategori_id',
        'notified_stok',
        'notified_kadaluarsa',
        
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function updateJumlahStok($jumlah_pembelian)
    {
        $this->jumlah_stok += $jumlah_pembelian;
        $this->save();
    }
}
