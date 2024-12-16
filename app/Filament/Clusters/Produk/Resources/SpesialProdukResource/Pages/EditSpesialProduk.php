<?php

namespace App\Filament\Clusters\Produk\Resources\SpesialProdukResource\Pages;

use App\Filament\Clusters\Produk\Resources\SpesialProdukResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpesialProduk extends EditRecord
{
    protected static string $resource = SpesialProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
