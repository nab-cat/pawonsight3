<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use App\Filament\Resources\RekomendasiResource;
use Sushi\Sushi;

class rekomendasi extends Model
{
    use Sushi;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'query'
        ];
    
    protected $schema = [
        'position' => 'integer',
        'title' => 'string',
        'link' => 'string',
        'product_link' => 'string',
        'product_id' => 'integer',
        'serpapi_product_api' => 'string',
        'source' => 'string',
        'price' => 'string',
        'extracted_price' => 'float',
        'thumbnail' => 'string',
        'description' => 'string',
        'rating' => 'float',
        'brand' => 'string',
    ];

    /**
     * Model Rows
     *
     * @return void
     */
    public function getRows()
    {
        // Tangkap nilai inputan user
        $query = session('search_query', 'Tepung Terigu');

        // API Request
        $response = Http::get('https://serpapi.com/search.json', [
            'engine' => 'google_shopping',
            'q' => $query,
            'location' => 'Sukoharjo Regency, Central Java, Indonesia',
            'google_domain' => 'google.co.id',
            'gl' => 'id',
            'hl' => 'id',
            'api_key' => '7e28d10861a569c39c492a29d099a89455300ff5d42821a4749e1d9ca28101c9'
        ])->json();

        // Check if 'products' key exists
        if (!isset($response['shopping_results'])) {
            return []; // Return an empty array if 'products' key is missing
        }

        // Filtering some attributes
        $products = Arr::map($response['shopping_results'], function ($item) {
            return [
                'position' => $item['position'] ?? null,
                'title' => $item['title'] ?? '',
                'link' => $item['link'] ?? '',
                'product_link' => $item['product_link'] ?? '',
                'product_id' => $item['product_id'] ?? null,
                'serpapi_product_api' => $item['serpapi_product_api'] ?? '',
                'source' => $item['source'] ?? '',
                'price' => $item['price'] ?? '',
                'extracted_price' => $item['extracted_price'] ?? 0,
                'thumbnail' => $item['thumbnail'] ?? '',
                'description' => $item['description'] ?? '',
                'rating' => $item['rating'] ?? 0,
                'brand' => $item['brand'] ?? '',
            ];
        });
 
        return $products;
    }
}
