<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PoskoResource\Pages;
use App\Models\Posko;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PoskoResource extends Resource
{
    protected static ?string $model = Posko::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Operasional';

    protected static ?string $navigationLabel = 'Posko';

    protected static ?string $modelLabel = 'posko';

    protected static ?string $pluralModelLabel = 'posko';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->placeholder('Masukkan Nama Posko'),
                Textarea::make('alamat')
                    ->required(),
                TextInput::make('kapasitas')
                    ->required()
                    ->placeholder('Masukkan Kapasitas Posko'),
                TextInput::make('jumlah_pengungsi')
                    ->placeholder('Masukkan Jumlah Pengungsi Saat ini'),
                Map::make('location')
                    ->label('Pilih lokasi di peta')
                    ->defaultLocation(-6.200000, 106.816666)
                    ->draggable(true)
                    ->clickable(true)
                    ->zoom(13)
                    ->afterStateHydrated(function ($state, $record, Set $set): void {
                        if ($record) {
                            $set('location', [
                                'lat' => $record->latitude,
                                'lng' => $record->longitude,
                            ]);
                        }
                    })
                    ->afterStateUpdated(function ($state, Set $set): void {
                        $set('latitude', $state['lat'] ?? null);
                        $set('longitude', $state['lng'] ?? null);
                    }),
                TextInput::make('latitude')
                    ->numeric()
                    ->required()
                    ->readOnly(),
                TextInput::make('longitude')
                    ->numeric()
                    ->required()
                    ->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Posko')
                    ->searchable(),
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(50),
                TextColumn::make('kapasitas')
                    ->label('Kapasitas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jumlah_pengungsi')
                    ->label('Pengungsi')
                    ->numeric()
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
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
            'index' => Pages\ManagePoskos::route('/'),
        ];
    }
}
