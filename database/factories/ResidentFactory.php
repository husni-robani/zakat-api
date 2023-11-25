<?php

namespace Database\Factories;

use App\Models\Resident;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resident>
 */
class ResidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Resident::class;
    public function definition(): array
    {
        return [
            'no_kk' => fake()->unique()->numerify('##########'),
            'house_number' => fake()->numerify('##A'),
            'total_muzaki' => fake()->numberBetween(1, 5),
        ];
    }
}
