<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Produk;
use App\Models\Stokbahan;
use App\Models\Pemasukan;

class Stats extends BaseWidget
{
    protected function getStats(): array
    {
        $jumlahProduk = Produk::count();
        $stokKadaluarsa = Stokbahan::where('status_kadaluarsa', true)->count();
        $laba = Pemasukan::sum('total_harga_keseluruhan');
        $statLaba = Pemasukan::select('total_harga_keseluruhan')->pluck('total_harga_keseluruhan')->toArray();

        // Tentukan pesan dan warna berdasarkan jumlah item yang kadaluarsa
        if ($stokKadaluarsa == 0) {
            $kadaluarsaMessage = 'Semua stok aman';
            $kadaluarsaColor = 'success';
        } else {
            $kadaluarsaMessage = 'Segera perbarui/lakukan stock ulang!';
            $kadaluarsaColor = 'danger';
        }

        return [
            Stat::make('Jumlah Produk', $jumlahProduk . ' produk')
                ->icon('heroicon-o-cube')
                ->description('Jumlah variasi produk')
                ->color('success'),
            Stat::make('Perhatian! Item yang Kadaluarsa', $stokKadaluarsa . ' item')
                ->icon('heroicon-o-shield-exclamation')
                ->description($kadaluarsaMessage)
                ->color($kadaluarsaColor),
            Stat::make('Jumlah omset bulan ini', 'Rp ' . number_format($laba, 0, ',', '.'))
                ->icon('heroicon-o-banknotes')
                ->description('Total omset yang didapat bulan ini')
                ->color('primary')
                ->chart($statLaba),
                
        ];
    }
}
