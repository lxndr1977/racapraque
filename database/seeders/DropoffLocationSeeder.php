<?php

namespace Database\Seeders;

use App\Models\DropoffLocation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DropoffLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DropoffLocation::factory(10)->create();
    }
}
