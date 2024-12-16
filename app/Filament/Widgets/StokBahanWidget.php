<?php

namespace App\Filament\Widgets;

use App\Models\Stokbahan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class StokBahanWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 6;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Stokbahan::query()
                    ->orderBy('status_kadaluarsa', 'desc')
                    ->orderBy('jumlah_stok', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama_bahan')
                    ->label('Nama Bahan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('jumlah_stok')
                    ->label('Stok')
                    ->icon('heroicon-o-inbox-stack')
                    ->sortable()
                    ->color(fn ($record) => 
                        $record->jumlah_stok <= $record->minimum_stok ? 'primary' : 'success'
                    ),

                Tables\Columns\TextColumn::make('minimum_stok')
                    ->label('Minimum Stok')
                    ->sortable(),

                Tables\Columns\TextColumn::make('satuan')
                    ->label('Satuan'),

                Tables\Columns\TextColumn::make('tanggal_kadaluarsa')
                    ->label('Tanggal Kadaluarsa')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status_kadaluarsa')
                    ->label('Status Kadaluarsa')
                    ->color(fn ($record) => $record->status_kadaluarsa ? 'danger' : 'success')
                    ->icon(fn ($record) => $record->status_kadaluarsa ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->formatStateUsing(fn ($state) => $state ? 'Kadaluarsa' : 'Aman')
                    ->sortable(),
            ])
            ->defaultSort('jumlah_stok', 'asc')
            ->filters([
                // Add any filters if needed
            ])
            ->actions([
                // Add any actions if needed
            ])
            ->paginated([
                'pageSize' => 5,
            ]);
    }
}
