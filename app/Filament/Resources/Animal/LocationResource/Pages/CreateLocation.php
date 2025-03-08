<?php

namespace App\Filament\Resources\Animal\LocationResource\Pages;

use App\Filament\Resources\Animal\LocationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLocation extends CreateRecord
{
    protected static string $resource = LocationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);    
    }
}
