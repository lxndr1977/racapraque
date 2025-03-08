<?php

use App\Enums\Animal\SizeEnum;
use App\Models\Animal\Location;
use App\Enums\Animal\GenderEnum;
use App\Enums\Animal\StatusEnum;
use App\Enums\Animal\SociabilityEnum;
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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', array_column(StatusEnum::cases(), 'value'));
            $table->string('slug')->unique();
            $table->enum('gender', array_column(GenderEnum::cases(), 'value'));
            $table->enum('size', array_column(SizeEnum::cases(), 'value'));
            $table->enum('specie', ['cat', 'dog']);
            $table->date('birth_date')->nullable();
            $table->date('intake_date')->nullable();
            $table->enum('sociable_with_cats', array_column(SociabilityEnum::cases(), 'value'));
            $table->enum('sociable_with_dogs', array_column(SociabilityEnum::cases(), 'value'));
            $table->enum('sociable_with_children', array_column(SociabilityEnum::cases(), 'value'));
            $table->json('temperaments')->nullable();  
            $table->json('health_conditions')->nullable();
            $table->json('special_needs')->nullable();
            $table->boolean('is_neutered')->default(true);
            $table->tinyText('short_description')->nullable();
            $table->text('full_description')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_adoption_ready')->default(true);
            $table->boolean('is_visible_on_site')->default(true);
            $table->foreignIdFor(Location::class)->constrained();
            $table->string('location_identification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
