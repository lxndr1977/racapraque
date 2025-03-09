<?php

namespace App\Filament\Resources\DropoffLocationResource\Pages;

use App\Filament\Resources\DropoffLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDropoffLocation extends EditRecord
{
    protected static string $resource = DropoffLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
