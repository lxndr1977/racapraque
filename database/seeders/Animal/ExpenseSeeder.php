<?php

namespace Database\Seeders\Animal;

use App\Models\Animal\Expense;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Expense::factory(50)->create();
    }
}
