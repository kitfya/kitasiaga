<?php

namespace App\Filament\Resources\PoskoResource\Pages;

use App\Filament\Resources\PoskoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePoskos extends ManageRecords
{
    protected static string $resource = PoskoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
