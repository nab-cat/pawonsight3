<?php

namespace App\Filament\Resources\RekomendasiResource\Pages;

use App\Filament\Resources\RekomendasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRekomendasis extends ManageRecords
{
    protected static string $resource = RekomendasiResource::class;

    public static function getCreateButtonLabel(): string
    {
        return 'Cari Produk'; // Customize the label here
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Cari Rekomendasi Produk') // Customize the label here,
        ];
    }
}
