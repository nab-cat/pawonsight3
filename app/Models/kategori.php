<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $fillable = [
        'id',
        'kategori',
    ];   

    public function stokBahans()
    {
        return $this->hasMany(StokBahan::class);
    }
}
