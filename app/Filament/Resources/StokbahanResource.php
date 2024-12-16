<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Kategori;
use Filament\Forms\Form;
use App\Models\Stokbahan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Toggle;
use Filament\Actions\Exports\Exporter;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\StokbahanExporter;
use App\Filament\Resources\StokbahanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;
use App\Filament\Resources\StokbahanResource\RelationManagers;

class StokbahanResource extends Resource
{
    protected static ?string $model = Stokbahan::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Stok Bahan';

    protected static ?string $pluralLabel = 'Daftar Barang Stok';

    protected static ?string $navigationGroup = 'Manajemen Stok';

    protected static ?int $sort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('nama_bahan')
                            ->label('Nama Bahan')
                            ->required()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                            ]),
                        Forms\Components\Select::make('kategori')
                            ->label('Kategori')
                            ->options(function () {
                                return Kategori::all()->pluck('kategori', 'id')->toArray(); 
                            })
                            ->required()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                            ]),
                        Forms\Components\Select::make('satuan')
                            ->label('Satuan')
                            ->options([
                                'kilogram' => 'Kilogram',
                                'gram' => 'Gram',
                                'kaleng' => 'Kaleng',
                                'dus' => 'Dus',
                                'sachet' => 'Sachet',
                                'pcs'=> 'Pcs'
                            ])
                            ->required()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                            ]),
                        Forms\Components\TextInput::make('jumlah_stok')
                            ->label('Jumlah stok yang masuk (Menurut satuan)')
                            ->numeric()
                            ->rules('min:1')
                            ->required()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                            ]),
                        Forms\Components\TextInput::make('minimum_stok')
                            ->label('Batas Stok Minimum')
                            ->helperText('Jumlah stok minimum yang harus ada. Berfungsi untuk notifikasi jika stok kurang dari batas minimum.')
                            ->numeric()
                            ->rules('min:1')
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                            ]),
                        Forms\Components\DatePicker::make('tanggal_masuk')
                            ->label('Tanggal Masuk')
                            ->native(false)
                            ->required()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                            ]),
                        Forms\Components\DatePicker::make('tanggal_kadaluarsa')
                            ->label('Tanggal Kadaluarsa')
                            ->helperText('Opsional, jika tidak ada tanggal kadaluarsa, kosongkan saja')
                            ->native(false)
                            ->nullable()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                            ]),
                        Forms\Components\TextInput::make('harga_satuan')
                            ->label('Harga Satuan dalam Rupiah')
                            ->numeric()
                            ->placeholder('Rp.')
                            ->required()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('nama_bahan')
                ->label('Nama Bahan')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('jumlah_stok')
                ->label('Jumlah Stok'),
            Tables\Columns\TextColumn::make('satuan')
                ->label('Satuan'),
            Tables\Columns\TextColumn::make('tanggal_masuk')
                ->label('Tanggal Masuk')
                ->sortable()
                ->date('d M y'),
            Tables\Columns\TextColumn::make('tanggal_kadaluarsa')
                ->label('Tanggal Kadaluarsa')
                ->sortable()
                ->date('d M y'),
            Tables\Columns\TextColumn::make('harga_satuan')
                ->label('Harga Satuan')
                ->money('IDR'), // Menggunakan format mata uang
            Tables\Columns\TextColumn::make('status_kadaluarsa')
                ->badge()
                ->color(fn ($record) => $record->status_kadaluarsa ? 'danger' : 'success')
                ->icon(fn ($record) => $record->status_kadaluarsa ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                ->formatStateUsing(fn ($state) => $state ? 'Kadaluarsa' : 'Aman')
                ->label('Kadaluarsa'),
        ])
        ->filters([
            Tables\Filters\Filter::make('status_kadaluarsa')
                ->label('Hanya Kadaluarsa')
                ->query(fn (Builder $query) => $query->where('status_kadaluarsa', true)),
        ])
        ->actions([
            Tables\Actions\EditAction::make()
                ->modalWidth('max-w-3xl'),
            Tables\Actions\DeleteAction::make(),

        ])
        ->headerActions([
            ExportAction::make()
            ->exporter(StokbahanExporter::class)
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
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
            'index' => Pages\ListStokbahans::route('/'),
            'create' => Pages\CreateStokbahan::route('/create'),
            'edit' => Pages\EditStokbahan::route('/{record}/edit'),
        ];
    }
}