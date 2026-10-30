<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogistikResource\Pages;
use App\Models\Logistik;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LogistikResource extends Resource
{
    protected static ?string $model = Logistik::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Operasional';

    protected static ?string $navigationLabel = 'Logistik';

    protected static ?string $modelLabel = 'barang logistik';

    protected static ?string $pluralModelLabel = 'logistik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                Select::make('tipe')
                    ->options([
                        'obat' => 'Obat-obatan',
                        'makanan' => 'Makanan & Minuman',
                        'pakaian' => 'Pakaian',
                        'lainnya' => 'Lainnya',
                    ])
                    ->required(),
                TextInput::make('jumlah')
                    ->placeholder('Masukkan Jumlah'),
                Select::make('posko_id')
                    ->relationship('posko', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Barang')
                    ->searchable(),
                TextColumn::make('tipe')
                    ->label('Kategori')
                    ->badge()
                    ->searchable(),
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('posko.name')
                    ->label('Posko')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLogistiks::route('/'),
        ];
    }
}
