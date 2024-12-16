<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'gambar_produk' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }
}
