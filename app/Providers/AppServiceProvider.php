<?php

namespace App\Providers;

use App\Services\TwilioService;
use App\Models\Animal\Sponsorship;
use Illuminate\Support\Facades\DB;
use App\Observers\SponsorshipObserver;
use App\Services\WhatsAppService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Console\Migrations\ResetCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sponsorship::observe(SponsorshipObserver::class);


      TwilioService::class;
      WhatsAppService::class;

        $isProhibited = $this->app->environment('production');

        DB::prohibitDestructiveCommands($isProhibited);

    }
}
