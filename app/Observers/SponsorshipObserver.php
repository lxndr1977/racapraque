<?php

namespace App\Observers;

use App\Models\Animal\Expense;
use App\Services\WhatsAppService;
use App\Models\Animal\Sponsorship;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SponsorshipActivatedMail;
use App\Mail\SponsorshipDeactivatedMail;
use App\Mail\SponsorshipConfirmationMail;
use App\Enums\Animal\SponsorshipStatusEnum;

class SponsorshipObserver
{
   public function __construct() {}

   /**
    * Handle the Sponsorship "created" event.
    */
   public function created(Sponsorship $sponsorship): void
   {
      $this->updateExpenseTotalSponsorship($sponsorship->expense_id);
   }


   /**
    * Handle the Sponsorship "updated" event.
    */
   public function updated(Sponsorship $sponsorship): void
   {

      $this->updateExpenseTotalSponsorship($sponsorship->expense_id);
   }

   /**
    * Handle the Sponsorship "deleted" event.
    */
   public function deleted(Sponsorship $sponsorship): void
   {
      $this->updateExpenseTotalSponsorship($sponsorship->expense_id);
   }

   /**
    * Recalcula o total de sponsorship baseado nos dados reais
    */
   private function updateExpenseTotalSponsorship(int $expenseId): void
   {
      $expense = Expense::find($expenseId);

      if (!$expense) {
         return;
      }

      // Calcula o total real baseado nos sponsorships ativos
      $totalSponsorship = Sponsorship::where('expense_id', $expenseId)
         ->where('status', SponsorshipStatusEnum::Active)
         ->sum('amount');

      $expense->total_sponsorship = $totalSponsorship;
      $expense->save();
   }

   /**
    * Handle the Sponsorship "restored" event.
    */
   public function restored(Sponsorship $sponsorship): void
   {
      //
   }

   /**
    * Handle the Sponsorship "force deleted" event.
    */
   public function forceDeleted(Sponsorship $sponsorship): void
   {
      //
   }
}
