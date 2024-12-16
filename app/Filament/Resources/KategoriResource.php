<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriResource\Pages;
use App\Filament\Resources\KategoriResource\RelationManagers;
use App\Models\Kategori;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Manajemen Stok';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Heading dan Description
                Card::make()
                    ->heading('Tambah Kategori Bahan')
                    ->description('Masukkan nama kategori bahan yang ingin ditambahkan.')
                    ->schema([
                        TextInput::make('kategori')
                            ->label('Nama Kategori')
                            ->required()
                            ->placeholder('Masukkan nama kategori'),
                    ]),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->header(function() {
                return view('components.custom-header', [
                    'title' => 'Daftar Kategori',
                    'message' => ' PERHATIAN: Apabila Anda menghapus salah satu kategori, maka semua produk yang terkait dengan kategori tersebut akan ikut terhapus.'
                ]);
            })
            ->columns([
                // Menampilkan kolom-kolom yang relevan untuk tabel
                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                // Tampilkan kolom lain jika ada
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                // Aksi untuk mengedit data kategori
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Aksi untuk bulk delete
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
            'index' => Pages\ListKategoris::route('/'),
            'create' => Pages\CreateKategori::route('/create'),
            'edit' => Pages\EditKategori::route('/{record}/edit'),
        ];
    }
}
