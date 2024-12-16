<?php

namespace App\Filament\Resources\StockopnameResource\Pages;

use App\Filament\Resources\StockopnameResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockopname extends EditRecord
{
    protected static string $resource = StockopnameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
