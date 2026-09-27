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
                    ->searchable(),
                TextColumn::make('alamat'),
                TextColumn::make('kapasitas'),
                TextColumn::make('jumlah_pengungsi'),
                ToggleColumn::make('is_active'),
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
