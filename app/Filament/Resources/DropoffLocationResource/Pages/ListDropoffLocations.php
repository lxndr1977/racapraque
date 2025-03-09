<?php

namespace App\Filament\Resources\DropoffLocationResource\Pages;

use App\Filament\Resources\DropoffLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDropoffLocations extends ListRecords
{
    protected static string $resource = DropoffLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
