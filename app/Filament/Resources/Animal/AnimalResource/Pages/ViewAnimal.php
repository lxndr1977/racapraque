<?php

namespace App\Filament\Resources\Animal\AnimalResource\Pages;

use App\Filament\Resources\Animal\AnimalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAnimal extends ViewRecord
{
    protected static string $resource = AnimalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
