<?php

namespace Database\Factories\Animal;

use App\Models\Animal\Animal;
use App\Enums\Animal\ExpenseTypeEnum;
use App\Enums\Animal\ExpenseRecurrenceEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(array_column(ExpenseTypeEnum::cases(), 'value')),
            'description' => $this->faker->sentence(),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'total_sponsorship' => $this->faker->randomFloat(2, 10, 500),
            'start_date' => $this->faker->optional()->date(),
            'end_date' => $this->faker->optional()->date(),
            'recurrence_days' => $this->faker->randomElement(array_column(ExpenseRecurrenceEnum::cases(), 'value')),
            'payment_link' => $this->faker->url(),
            'animal_id' => Animal::inRandomOrder()->first()->id,
        ];
    }
}
