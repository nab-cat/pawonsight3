<?php

namespace App\Filament\Resources\StockopnameResource\Pages;

use App\Filament\Resources\StockopnameResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStockopnames extends ListRecords
{
    protected static string $resource = StockopnameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
