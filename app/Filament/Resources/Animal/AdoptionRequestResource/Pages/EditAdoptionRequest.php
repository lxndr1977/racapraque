<?php

namespace App\Filament\Resources\Animal\AdoptionRequestResource\Pages;

use App\Filament\Resources\Animal\AdoptionRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdoptionRequest extends EditRecord
{
    protected static string $resource = AdoptionRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);    
    }
}
