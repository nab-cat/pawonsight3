<?php

namespace App\Filament\Resources\StokbahanResource\Pages;

use App\Filament\Resources\StokbahanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;

class ListStokbahans extends ListRecords
{
    protected static string $resource = StokbahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array{
        return [
            'Semua' => Tab::make(),
            'Bahan Baku' => Tab::make()
            ->modifyQueryUsing(function ($query) {
                $query->where('kategori', '1'); 
            }),
            
            'Bahan Topping' => Tab::make()
            ->modifyQueryUsing(function ($query) {
                $query->where('kategori', '2'); 
            }),
        
            'Packaging' => Tab::make()
            ->modifyQueryUsing(function ($query) {
                $query->where('kategori', '3'); 
            }),
        ];
    }
}
