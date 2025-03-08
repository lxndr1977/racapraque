<?php

namespace Database\Seeders\Animal;

use App\Models\Animal\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sponsorship::factory(10)->create();
    }
}
