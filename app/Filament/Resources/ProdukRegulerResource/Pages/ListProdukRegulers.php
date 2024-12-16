<?php

namespace App\Filament\Resources\ProdukRegulerResource\Pages;

use App\Filament\Resources\ProdukRegulerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProdukRegulers extends ListRecords
{
    protected static string $resource = ProdukRegulerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
