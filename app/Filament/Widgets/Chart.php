<?php

namespace App\Filament\Widgets;

use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Filament\Widgets\ChartWidget;

class Chart extends ChartWidget
{
    protected static ?string $heading = 'Catatan Pemasukan dan Pengeluaran';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = '1/2';

    protected static ?string $icon = 'heroicon-o-presentation-chart-bar';

    protected function getData(): array
    {
        // Ambil data pemasukan dan pengeluaran
        $pemasukanData = Pemasukan::select('created_at', 'total_harga_keseluruhan')->get();
        $pengeluaranData = Pengeluaran::select('created_at', 'total_pengeluaran')->get();

        // Format data untuk chart
        $chartData = [];
        foreach ($pemasukanData as $pemasukan) {
            $date = $pemasukan->created_at->format('Y-m-d');
            $chartData[$date]['pemasukan'] = $pemasukan->total_harga_keseluruhan;
        }
        foreach ($pengeluaranData as $pengeluaran) {
            $date = $pengeluaran->created_at->format('Y-m-d');
            $chartData[$date]['pengeluaran'] = $pengeluaran->total_pengeluaran;
        }

        // Siapkan data untuk chart
        $dates = array_keys($chartData);
        $pemasukanChart = array_map(fn($date) => $chartData[$date]['pemasukan'] ?? 0, $dates);
        $pengeluaranChart = array_map(fn($date) => $chartData[$date]['pengeluaran'] ?? 0, $dates);

        return [
            'labels' => $dates,
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => $pemasukanChart,
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'fill' => true,
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $pengeluaranChart,
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'fill' => true,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}