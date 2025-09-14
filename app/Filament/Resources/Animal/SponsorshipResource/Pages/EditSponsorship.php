<?php

namespace App\Filament\Resources\Animal\SponsorshipResource\Pages;

use Filament\Actions;
use App\Jobs\SendSponsorshipEmailJob;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Animal\SponsorshipResource;

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

   protected function mutateFormDataBeforeCreate(array $data): array
   {
      $this->record->sendEmails = $data['sendEmails'] ?? false;

      return $data;
   }

   protected function mutateFormDataBeforeSave(array $data): array
   {
      $this->record->sendEmails = $data['sendEmails'] ?? false;

      return $data;
   }

   protected function afterSave(): void
   {
      $data = $this->form->getState();

      if (!empty($data['sendEmails']) && $data['sendEmails'] === true) {
         SendSponsorshipEmailJob::dispatch($this->record);
      }
   }
}
