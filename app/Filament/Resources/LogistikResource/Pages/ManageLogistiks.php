<?php

namespace App\Filament\Resources\LogistikResource\Pages;

use App\Filament\Resources\LogistikResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLogistiks extends ManageRecords
{
    protected static string $resource = LogistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
