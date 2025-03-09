<?php

namespace App\Filament\Resources\DropoffLocationResource\Pages;

use App\Filament\Resources\DropoffLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDropoffLocation extends ViewRecord
{
    protected static string $resource = DropoffLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
