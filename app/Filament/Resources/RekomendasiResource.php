<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Rekomendasi;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RekomendasiResource\Pages;
use App\Filament\Resources\RekomendasiResource\RelationManagers;
use App\Filament\Resources\RekomendasiResource\Pages\ManageRekomendasis;
use Filament\Forms\Components\Actions;

class RekomendasiResource extends Resource
{
    protected static ?string $model = Rekomendasi::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected bool $canCreateAnother = false;
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // Input field for query
                TextInput::make('query')
                ->label('Search Query')
                ->placeholder('Masukkan nama produk')
                ->reactive()
                ->afterStateUpdated(fn ($state) => session(['search_query' => $state])),
     
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->header(function () {
            return view('components.header-rekomendasi');
            })
        ->columns([
            ImageColumn::make('thumbnail')
                ->label('Gambar')
                ->size(100,100)
                ->rounded(),


            TextColumn::make('title')
                ->label('Nama Barang')
                ->weight('bold')
                ->wrap()
                ->size('sm')
                //->limit(25)
                ->sortable()
                ->searchable(),

            TextColumn::make('link')
                ->label('Link produk')
                ->formatStateUsing(fn ($state) => '<a href="' . $state . '" target="_blank" class="text-blue-500 underline">Ke halaman produk</a>')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->html(),

            TextColumn::make('source')
                ->label('Source')
                ->sortable()
                ->searchable(),

            TextColumn::make('extracted_price')
                ->label('Harga')
                ->icon('heroicon-o-banknotes')
                ->colors(['primary'])
                ->weight('bold')
                ->sortable()
                ->formatStateUsing(fn ($state) => 'Rp' . number_format($state, 2)),

            BadgeColumn::make('rating')
                ->label('Rating')
                ->icon('heroicon-o-star')
                ->colors([
                    'danger' => static fn($state): bool => $state <= 3,
                    'warning' => static fn($state): bool => $state > 3 && $state <= 4.5,
                    'success' => static fn($state): bool => $state > 4.5,
                ])
                ->sortable(),
        ])
        ->filters([
            // SelectFilter::make('brand')
            //     ->multiple()
            //     ->options(Rekomendasi::select('brand')
            //         ->distinct()
            //         ->pluck('brand', 'brand')
            //         ->toArray()),
            // Tambahkan filter lainnya jika diperlukan
        ])
        ->actions([
            // EditAction::make(),
            // DeleteAction::make(),
        ])
        ->bulkActions([
           // DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRekomendasis::route('/'),
        ];
    }
}
