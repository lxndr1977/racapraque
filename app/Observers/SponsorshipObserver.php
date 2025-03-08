<?php

namespace App\Observers;

use App\Enums\Animal\SponsorshipStatusEnum;
use App\Models\Animal\Sponsorship;
use App\Models\Animal\Expense;

class SponsorshipObserver
{
    /**
     * Handle the Sponsorship "created" event.
     */
    public function created(Sponsorship $sponsorship): void
    {
        //
    }

    /**
     * Handle the Sponsorship "updated" event.
     */
    public function updated(Sponsorship $sponsorship): void
    {
        if ($sponsorship->isDirty('status')) {
            $expense = Expense::find($sponsorship->expense_id);

            if (!$expense) {
                return;
            }

            if ($sponsorship->status === SponsorshipStatusEnum::Active) {
                // Se o status for Active, atualize o total_sponsorship com o valor de amount
                $expense->total_sponsorship = $sponsorship->amount;
            } elseif ($sponsorship->status === SponsorshipStatusEnum::Inactive) {
                // Se o status for Inactive, zere o total_sponsorship
                $expense->total_sponsorship = 0;
            }

            $expense->save();
        }
    }

    /**
     * Handle the Sponsorship "deleted" event.
     */
    public function deleted(Sponsorship $sponsorship): void
    {
        $expense = Expense::find($sponsorship->expense_id);

        if ($expense) {
            $expense->total_sponsorship = 0;
            $expense->save();
        }
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
