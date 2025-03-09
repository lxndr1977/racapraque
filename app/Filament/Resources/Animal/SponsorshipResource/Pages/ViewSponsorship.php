<?php

namespace App\Filament\Resources\Animal\SponsorshipResource\Pages;

use App\Filament\Resources\Animal\SponsorshipResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSponsorship extends ViewRecord
{
    protected static string $resource = SponsorshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
