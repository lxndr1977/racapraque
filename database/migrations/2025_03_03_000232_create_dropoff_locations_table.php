<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dropoff_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('number');
            $table->string('complement')->nullable();
            $table->string('city');
            $table->string('neighborhood');
            $table->string('state', 2);
            $table->string('zip_code', 9);
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->boolean('accepts_only_plastic_caps')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dropoff_locations');
    }
};
