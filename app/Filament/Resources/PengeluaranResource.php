<?php

namespace App\Filament\Resources;

use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Stokbahan;
use App\Models\Pengeluaran;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkAction; 
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\PengeluaranResource\Pages\EditPengeluaran;
use App\Filament\Resources\PengeluaranResource\Pages\ListPengeluarans;
use App\Filament\Resources\PengeluaranResource\Pages\CreatePengeluaran;

class PengeluaranResource extends Resource
{
    protected static ?string $model = Pengeluaran::class;

    protected static ?string $navigationGroup = 'Manajemen Keuangan';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('nama_bahan')
                ->label('Nama Bahan')
                ->options(function () {
                    return Stokbahan::orderBy('created_at', 'desc')->pluck('nama_bahan', 'id')->toArray();
                })
                ->searchable()
                ->required()
                ->helperText('Tambah bahan baku baru pada stok bahan jika bahan baku yang dicari tidak ditemukan.')
                ->reactive()
                ->afterStateUpdated(function (callable $set, $state) {
                    $bahan = Stokbahan::find($state);
                    if ($bahan) {
                        $set('harga_satuan', $bahan->harga_satuan);
                    }
                }),
            TextInput::make('harga_satuan')
                ->label('Harga Satuan')
                ->required()
                ->reactive()
                ->numeric()
                ->formatStateUsing(fn ($state) => 'Rp' . number_format($state, 2))
                ->dehydrateStateUsing(fn ($state) => $state),
            TextInput::make('jumlah_pembelian')
                ->label('Jumlah Pembelian')
                ->numeric()
                ->required()
                ->reactive()
                ->afterStateUpdated(function (callable $set, $state, callable $get) {
                    $harga_satuan = $get('harga_satuan');
                    $set('total_pengeluaran', $state * $harga_satuan);
                }),
            TextInput::make('total_pengeluaran')
                ->label('Total Pengeluaran')
                ->numeric()
                ->formatStateUsing(fn ($state) => 'Rp' . number_format($state, 2))
                ->prefix("Rp"),
            DatePicker::make('tanggal_pembelian')
                ->label('Tanggal Pembelian')
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
        ->header(function () {
            return view('components.header-pengeluaran');
            })
        ->columns([
                TextColumn::make('stokbahan.nama_bahan')
                    ->label('Nama Bahan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('harga_satuan')
                    ->label('Harga Satuan')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp' . number_format($state, 2)),
                TextColumn::make('jumlah_pembelian')
                    ->label('Jumlah Pembelian')
                    ->sortable(),
                TextColumn::make('total_pengeluaran')
                    ->label('Total Pengeluaran')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp' . number_format($state, 2)),
                TextColumn::make('tanggal_pembelian')
                    ->label('Tanggal Pembelian')
                    ->sortable()
                    ->date(),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
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
            'index' => PengeluaranResource\Pages\ListPengeluarans::route('/'),
            'create' => PengeluaranResource\Pages\CreatePengeluaran::route('/create'),
            //'edit' => PengeluaranResource\Pages\EditPengeluaran::route('/{record}/edit'),
        ];
    }
}

