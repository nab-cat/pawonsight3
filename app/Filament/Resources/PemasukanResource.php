<?php

namespace App\Filament\Resources;

use Log;
use Filament\Forms;
use Filament\Tables;
use App\Models\produk;
use Filament\Forms\Form;
use App\Models\Pemasukan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PemasukanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PemasukanResource\RelationManagers;
use Termwind\Components\Span;

class PemasukanResource extends Resource
{
    protected static ?string $model = Pemasukan::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Manajemen Keuangan';

    protected static ?string $label = 'Pemasukan';

    protected static ?string $pluralLabel = 'Pemasukan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('items')
                    ->label('Produk Terjual')
                    ->schema([
                        Select::make('id_produk')
                            ->label('Produk')
                            ->options(function () {
                                return Produk::orderBy('created_at', 'desc')->pluck('nama_produk', 'id_produk')->toArray(); 
                            })
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $produk = Produk::find($state);
                                if ($produk) {
                                    $set('harga_produk', $produk->harga);
                                    $set('kategori', $produk->kategori);
                                }
                            }),
                        TextInput::make('kategori')
                            ->label('Kategori')
                            ->disabled(),
                        TextInput::make('jumlah_terjual')
                            ->label('Jumlah Terjual')
                            ->numeric()
                            ->rules(['required', 'min:1'])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $get, callable $set) {
                                $harga = $get('harga_produk');
                                $jumlah = $get('jumlah_terjual');
                                if ($harga && $jumlah) {
                                    $set('total_harga', $harga * $jumlah);
                                }
                                // Update total harga keseluruhan
                                $items = $get('../../items');
                                $total = collect($items)->sum(function ($item) {
                                    return $item['total_harga'];
                                });
                                $set('../../total_harga_keseluruhan', $total);
                            }),
                        TextInput::make('harga_produk')
                            ->label('Harga Produk')
                            ->numeric()
                            ->disabled(),
                        TextInput::make('total_harga')
                            ->label('Total Harga')
                            ->numeric()
                            ->disabled()
                            ->rules(['required', 'min:0'])
                            ->required(),
                    ])
                    ->createItemButtonLabel('Tambah Produk')
                    ->minItems(1)
                    ->columnSpanFull(),
                TextInput::make('total_harga_keseluruhan')
                    ->label('Kalkulasi Otomatis Total Harga Keseluruhan')
                    ->numeric()
                    ->disabled()
                    ->rules(['required', 'min:0'])
                    ->required()
                    ->reactive(),
                TextInput::make('total_harga_keseluruhan')
                    ->label('Masukkan Ulang Total Harga Keseluruhan')
                    ->helperText('Konfirmasi Bahwa Total harga keseluruhan harus sama dengan total harga dari semua produk yang terjual.')
                    ->numeric()
                    ->rules(['required', 'min:0'])
                    ->required()
                    ->reactive(),
                DatePicker::make('created_at')
                    ->label('Tanggal Transaksi')
                    ->native(false)
                    ->required(),
                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(3)
                    ->placeholder('Opsional')
                    ->nullable(),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('items')
                    ->label('Detail Produk')
                    ->getStateUsing(function ($record) {
                        return collect($record->items)
                            ->map(function ($item) {
                                $produk = Produk::find($item['id_produk']);
                                return "{$produk->nama_produk} ({$item['jumlah_terjual']})";
                            })
                            ->implode(', ');
                    }),
                TextColumn::make('total_harga_keseluruhan')
                    ->label('Total Harga Keseluruhan')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('created_at')
                    ->label('Data masuk pada')
                    ->date('D, d M Y')
                    ->sortable()
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
               // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Tambahkan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPemasukans::route('/'),
            'create' => Pages\CreatePemasukan::route('/create'),
            //'edit' => Pages\EditPemasukan::route('/{record}/edit'),
        ];
    }
    
}
