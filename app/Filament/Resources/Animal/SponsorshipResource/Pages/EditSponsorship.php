<?php

namespace App\Filament\Resources\Animal\SponsorshipResource\Pages;

use App\Filament\Resources\Animal\SponsorshipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSponsorship extends EditRecord
{
    protected static string $resource = SponsorshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
