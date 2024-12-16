<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockopnameResource\Pages;
use App\Filament\Resources\StockopnameResource\RelationManagers;
use App\Models\stokbahan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockopnameResource extends Resource
{
    protected static ?string $model = Stokbahan::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Stock Opname';

    protected static ?string $pluralLabel = 'Stock Opname';

    protected static ?string $navigationGroup = 'Manajemen Stok';


    
    public static function canCreate(): bool
    {
        return false;
    }


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('jumlah_stok')
                ->label('Ubah jumlah stok')
                ->required(),
            Forms\Components\TextInput::make('satuan')
                ->label('Satuan')
                ->default(fn ($record) => $record->satuan)
                ->disabled(),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->header(function () {
            return view('components.header-SO');
            })
            ->columns([
                Tables\Columns\TextColumn::make('nama_bahan')
                    ->label('Nama Bahan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_stok')
                    ->label('Jumlah Stok')
                    ->formatStateUsing(function ($record) {
                        return $record->jumlah_stok . ' ' . $record->satuan;
                    }),
                Tables\Columns\TextColumn::make('tanggal_masuk')->label('Tanggal Masuk'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('increaseQty')
                ->label('Tambah')
                ->color('success')
                ->icon('heroicon-o-plus-circle')
                ->action(function ($record) {
                    $record->jumlah_stok += 1;
                    $record->save();
                }),
                Tables\Actions\Action::make('decreaseQty')
                ->label('Kurang')
                ->color('danger')
                ->icon('heroicon-o-minus-circle')
                ->action(function ($record) {
                    $record->jumlah_stok -= 1;
                    $record->save();
                }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockopnames::route('/'),
            'create' => Pages\CreateStockopname::route('/create'),
            'edit' => Pages\EditStockopname::route('/{record}/edit'),
        ];
    }
}
