<?php

namespace App\Filament\Resources\ProdukRegulerResource\Pages;

use App\Filament\Resources\ProdukRegulerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProdukReguler extends EditRecord
{
    protected static string $resource = ProdukRegulerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
