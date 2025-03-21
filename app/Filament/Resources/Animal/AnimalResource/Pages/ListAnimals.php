<?php

namespace App\Filament\Resources\Animal\AnimalResource\Pages;

use App\Filament\Resources\Animal\AnimalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnimals extends ListRecords
{
    protected static string $resource = AnimalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
