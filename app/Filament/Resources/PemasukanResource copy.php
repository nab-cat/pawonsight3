<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\produk;
use Filament\Forms\Form;
use App\Models\Pemasukan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PemasukanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PemasukanResource\RelationManagers;

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
                    }),
                TextInput::make('harga_produk')
                    ->label('Harga Produk')
                    ->numeric()
                    ->disabled(),
                TextInput::make('total_harga')
                    ->label('Total Harga')
                    ->numeric()
                    ->disabled(),
                DatePicker::make('created at')
                    ->label('Tanggal Transaksi')
                    ->default(now())
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
                TextColumn::make('produk.nama_produk')
                    ->label('Nama Produk')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('produk.kategori')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('jumlah_terjual')
                    ->label('Jumlah Terjual')
                    ->sortable(),
                TextColumn::make('produk.harga')
                    ->label('Harga Produk')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return 'Rp ' . number_format($record->produk->harga * $record->jumlah_terjual, 0, ',', '.');
                    }),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'edit' => Pages\EditPemasukan::route('/{record}/edit'),
        ];
    }
}
