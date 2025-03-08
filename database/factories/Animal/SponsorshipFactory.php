<?php

namespace Database\Factories\Animal;

use App\Enums\Animal\SponsorshipStatusEnum;
use App\Models\User;
use App\Models\Animal\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal\Sponsorship>
 */
class SponsorshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::exists() ? User::inRandomOrder()->value('id') : User::factory()->create()->id,
            'expense_id' => Expense::exists() ? Expense::inRandomOrder()->value('id') : Expense::factory()->create()->id,
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement(array_column(SponsorshipStatusEnum::cases(), 'value')),      
            'notes' => $this->faker->sentence,
        ];
    }
} 
 