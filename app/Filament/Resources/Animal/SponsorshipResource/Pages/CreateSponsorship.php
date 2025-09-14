<?php

namespace App\Filament\Resources\Animal\SponsorshipResource\Pages;

use Filament\Actions;
use App\Jobs\SendSponsorshipEmailJob;
use Filament\Resources\Pages\CreateRecord;
use App\Observers\Animal\SponsorshipObserver;
use App\Filament\Resources\Animal\SponsorshipResource;

class CreateSponsorship extends CreateRecord
{
   protected static string $resource = SponsorshipResource::class;

   protected function mutateFormDataBeforeCreate(array $data): array
   {
      $data['sendEmails'] = $data['sendEmails'] ?? false;

      return $data;
   }
   protected function afterCreate(): void
   {
      if ($this->form->getState()['sendEmails'] ?? false) {
         SendSponsorshipEmailJob::dispatch($this->record);
      }
   }
}
