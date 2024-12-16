<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Produk as ClustersProduk;
use Filament\Forms;
use Filament\Tables;
use App\Models\Produk;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProdukRegulerResource\Pages;
use App\Filament\Resources\ProdukRegulerResource\RelationManagers;

class ProdukRegulerResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $modelLabel = 'Produk Reguler';

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $cluster = ClustersProduk::class;

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
                TextEntry::make('stok')->label('Stok'),
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
                return view('components.header-produkreguler');
            })
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('gambar_produk')
                        ->height('300px')
                        ->width('100%')
                        ->extraImgAttributes(['class' => 'rounded-lg']),
                        //->alignCenter(),
                    Tables\Columns\TextColumn::make('nama_produk')
                        ->label('Nama Produk')
                        ->weight('bold')
                        ->size('lg')
                        ->searchable(),
                        //->alignCenter(),
                    Tables\Columns\TextColumn::make('harga')
                        ->label('Harga')
                        //->alignCenter()
                        ->formatStateUsing(fn (string $state): string => 'Rp ' . number_format($state, 0, ',', '.')),
                    Tables\Columns\TextColumn::make('stok')
                        ->label('Stok')
                        //->alignCenter()
                        ->weight('bold'),
                ]),
            ])
            ->actions([
                Tables\Actions\Action::make('increaseQty')
                ->label('Tambah')
                ->color('success')
                ->icon('heroicon-o-plus-circle')
                ->action(function ($record) {
                    $record->stok += 1;
                    $record->save();
                }),
                Tables\Actions\Action::make('decreaseQty')
                ->label('Kurang')
                ->color('danger')
                ->icon('heroicon-o-minus-circle')
                ->action(function ($record) {
                    $record->stok -= 1;
                    $record->save();
                }),
            ])
            ->contentGrid([
                'sm' => 1,
                'md' => 2,
                'xl' => 2,
            ])
            ->paginated(18);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProdukRegulers::route('/'),
            'create' => Pages\CreateProdukReguler::route('/create'),
            'edit' => Pages\EditProdukReguler::route('/{record}/edit'),
        ];
    }
}
