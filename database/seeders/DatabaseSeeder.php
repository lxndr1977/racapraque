<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\User\RoleEnum;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Animal\AnimalSeeder;
use Database\Seeders\Animal\ExpenseSeeder;
use Database\Seeders\Animal\LocationSeeder;
use Database\Seeders\Animal\SponsorshipSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Alexandre',
            'email' => 'alexandre@alexandre.com.br',
            'role' => RoleEnum::Admin,
            'password' => Hash::make('091177')
        ]);

        $this->call(LocationSeeder::class);
        $this->call(AnimalSeeder::class);
        $this->call(ExpenseSeeder::class);
        $this->call(SponsorshipSeeder::class);
        $this->call(DropoffLocationSeeder::class);
    }
}



