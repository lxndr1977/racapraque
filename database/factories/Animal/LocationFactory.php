<?php

namespace Database\Factories\Animal;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->safeEmail,
            'whatsapp' => $this->faker->phoneNumber,
            'is_volunteer' => $this->faker->boolean,        
        ];
    }
}
