<?php

namespace App\Filament\Widgets;

use App\Models\Produk;
use Filament\Widgets\ChartWidget;

class ProdukChart extends ChartWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = '1/2';

    protected static ?string $heading = 'Stok Produk';

    protected function getData(): array
    {
        // Ambil data stok produk dari model Produk
        $produk = Produk::all();

        // Siapkan data untuk chart
        $labels = $produk->pluck('nama_produk')->toArray();
        $data = $produk->pluck('stok')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Stok Produk',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                    'datalabels' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
