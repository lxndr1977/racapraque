<?php

use App\Enums\Animal\SponsorshipStatusEnum;
use App\Models\User;
use App\Models\Animal\Expense;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Expense::class);
            $table->decimal('amount');
            $table->boolean('status')
                ->array_column(SponsorshipStatusEnum::cases(), 'value')
                ->default(SponsorshipStatusEnum::Active);
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsorships');
    }
};
