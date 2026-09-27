<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RelawanResource\Pages;
use App\Models\Relawan;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RelawanResource extends Resource
{
    protected static ?string $model = Relawan::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->placeholder('Masukkan Nama'),
                        TextInput::make('email')
                            ->required()
                            ->placeholder('Masukkan Email'),
                        TextInput::make('phone')
                            ->placeholder('Masukkan No. Hp'),
                        TextInput::make('password')
                            ->required()
                            ->password()
                            ->placeholder('Masukkan Password'),
                    ]),
                Select::make('bidang')
                    ->options([
                        'sar' => 'SAR',
                        'medis' => 'Medis',
                        'logistik' => 'Logistik',
                        'lainnya' => 'Lainnya',
                    ]),
                TextInput::make('instansi'),
                Select::make('posko_id')
                    ->relationship('posko', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('bidang'),
                TextColumn::make('instansi'),
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
            'index' => Pages\ManageRelawans::route('/'),
        ];
    }
}
