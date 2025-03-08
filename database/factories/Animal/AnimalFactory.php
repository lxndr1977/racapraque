<?php

namespace Database\Factories\Animal;

use App\Models\Animal\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'status' => $this->faker->randomElement(['active', 'inactive', 'adopted', 'dead']),
            'slug' => $this->faker->unique()->slug,
            'gender' => $this->faker->randomElement(['m', 'f']),
            'size' => $this->faker->randomElement(['xs', 'sm', 'md', 'lg', 'xl']),
            'specie' => $this->faker->randomElement(['cat', 'dog']),
            'sociable_with_cats' => $this->faker->randomElement(['y', 'n', 'n/e']),
            'sociable_with_dogs' => $this->faker->randomElement(['y', 'n', 'n/e']),
            'sociable_with_children' => $this->faker->randomElement(['y', 'n', 'n/e']),
            'temperaments' => json_encode($this->faker->randomElements(['calm', 'aggressive', 'friendly', 'shy', 'playful'], $count = 2)),
            'special_needs' => json_encode($this->faker->randomElements(['blind', 'deaf', 'diabetic', 'needs medication'], $count = 1)),
            'is_neutered' => $this->faker->boolean,
            'short_description' => $this->faker->sentence,
            'full_description' => $this->faker->paragraph, 'notes' => $this->faker->optional()->text,
            'is_adoption_ready' => $this->faker->boolean,
            'is_visible_on_site' => $this->faker->boolean,
            'location_id' => Location::inRandomOrder()->first()->id, 
        ];
    }
}
