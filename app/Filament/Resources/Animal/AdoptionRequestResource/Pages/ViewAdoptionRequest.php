<?php

namespace App\Filament\Resources\Animal\AdoptionRequestResource\Pages;

use App\Filament\Resources\Animal\AdoptionRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAdoptionRequest extends ViewRecord
{
    protected static string $resource = AdoptionRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
