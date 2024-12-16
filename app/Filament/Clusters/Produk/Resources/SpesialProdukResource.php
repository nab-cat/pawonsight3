<?php

namespace App\Filament\Clusters\Produk\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SpesialProduk;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Filament\Clusters\Produk;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Produk\Resources\SpesialProdukResource\Pages;
use App\Filament\Clusters\Produk\Resources\SpesialProdukResource\RelationManagers;

class SpesialProdukResource extends Resource
{
    protected static ?string $model = SpesialProduk::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Produk Seasonal';

    protected static ?string $label = 'Produk Seasonal';    

    protected static ?string $cluster = Produk::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Produk')
                    ->schema([
                        Forms\Components\TextInput::make('nama_produk')
                            ->label('Nama Produk')
                            ->required()
                            ->columnSpan(2),
                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->required()
                            ->columnSpan(2),
                        Forms\Components\Select::make('kategori')
                            ->label('Kategori')
                            ->options([
                                'food' => 'Food',
                                'beverage' => 'Beverage',
                            ])
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('harga')
                            ->label('Harga')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('stok')
                            ->label('Stok')
                            ->numeric()
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\FileUpload::make('gambar_produk')
                            ->disk('public') // Disk penyimpanan
                            ->directory('gambar_produk') // Folder dalam disk
                            ->label('Gambar Produk')
                            ->image()
                            ->columnSpan(2), // Hanya mengizinkan gambar
                            //->required(), // File harus diunggah        
                    ])
                    ->columns(2),
                   
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('nama_produk')->label('Nama Produk'),
                TextEntry::make('kategori')->label('Kategori'),
                TextEntry::make('deskripsi')->label('Deskripsi')->columnSpanFull(),
                TextEntry::make('harga')->label('Harga')
                    ->formatStateUsing(fn (string $state): string => 'Rp ' . number_format($state, 0, ',', '.')),
                ImageEntry::make('gambar_produk')->label('Gambar Produk'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->header(function () {
                return view('components.header-spesialproduk');
            })
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('gambar_produk')
                        ->height('300px')
                        ->width('100%')
                        ->extraImgAttributes(['class' => 'rounded-lg'])
                        ->alignCenter(),
                    Tables\Columns\TextColumn::make('nama_produk')
                        ->label('Nama Produk')
                        ->weight('bold')
                        ->size('lg')
                        ->searchable()
                        ->alignCenter(),
                    Tables\Columns\TextColumn::make('harga')
                        ->label('Harga')
                        ->alignCenter()
                        ->formatStateUsing(fn (string $state): string => 'Rp ' . number_format($state, 0, ',', '.')),
                ]),
            ])
            ->contentGrid([
                'md' => 1,
                'xl' => 2,
            ])
            ->paginated(18);
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
            'index' => Pages\ListSpesialProduks::route('/'),
            'create' => Pages\CreateSpesialProduk::route('/create'),
            'edit' => Pages\EditSpesialProduk::route('/{record}/edit'),
        ];
    }
}
