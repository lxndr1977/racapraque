<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use App\Models\Animal\Sponsorship;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SponsorshipActivatedMail;
use Illuminate\Queue\SerializesModels;
use App\Mail\SponsorshipDeactivatedMail;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\SponsorshipConfirmationMail;
use App\Enums\Animal\SponsorshipStatusEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSponsorshipEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Sponsorship $sponsorship;

    public int $tries = 2;

    public int $timeout = 120;

    public function __construct(Sponsorship $sponsorship)
    {
        $this->sponsorship = $sponsorship;
    }

    public function handle(): void
    {
        try {
            match ($this->sponsorship->status) {
                SponsorshipStatusEnum::Active =>
                    Mail::to($this->sponsorship->user->email)
                        ->queue(new SponsorshipActivatedMail($this->sponsorship)),

                SponsorshipStatusEnum::Inactive =>
                    Mail::to($this->sponsorship->user->email)
                        ->queue(new SponsorshipDeactivatedMail($this->sponsorship)),

                SponsorshipStatusEnum::Pending =>
                    Mail::to($this->sponsorship->user->email)
                        ->queue(new SponsorshipConfirmationMail($this->sponsorship)),
            };
        } catch (Throwable $e) {
            Log::error('Erro ao enviar email de patrocínio: ' . $e->getMessage(), [
                'sponsorship_id' => $this->sponsorship->id,
            ]);
        }
    }

}
