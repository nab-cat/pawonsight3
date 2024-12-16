<?php

namespace App\Filament\Resources\StokbahanResource\Pages;

use App\Filament\Resources\StokbahanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStokbahan extends EditRecord
{
    protected static string $resource = StokbahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
