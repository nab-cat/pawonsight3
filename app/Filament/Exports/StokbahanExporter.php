<?php

namespace App\Filament\Exports;

use App\Models\Stokbahan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Actions\Exports\Models\Export;

class StokbahanExporter extends Exporter
{
    protected static ?string $model = Stokbahan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nama_bahan'),
            ExportColumn::make('kategori'),
            ExportColumn::make('jumlah_stok'),
            ExportColumn::make('minimum_stok'),
            ExportColumn::make('satuan'),
            ExportColumn::make('tanggal_masuk'),
            ExportColumn::make('tanggal_kadaluarsa'),
            ExportColumn::make('harga_satuan'),
            ExportColumn::make('status_kadaluarsa'),
            ExportColumn::make('kategori_id'),
            ExportColumn::make('notified_stok'),
            ExportColumn::make('notified_kadaluarsa'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Data stok bahan sudah berhasil diexport. ' . number_format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' telah diexport.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
