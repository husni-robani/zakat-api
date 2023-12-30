<?php

namespace Database\Factories;

use App\Models\Guest;
use App\Models\Resident;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donor>
 */
class DonorFactory extends Factory
{
    private function createDonorable($randomNumber){
        if ($randomNumber === 1){
            return [
                Resident::factory()->count(1)->create(),
                Resident::class
            ];
        }else{
            return [
                Guest::factory()->count(1)->create(),
                Guest::class
            ];
        }
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $donorable = $this->createDonorable(fake()->randomElement([1, 2]));
        return [
            'name' => fake()->name,
            'email' => fake()->email,
            'phone_number' => fake()->phoneNumber,
            'donorable_id' => $donorable[0]->value('id'),
            'donorable_type' => $donorable[1]
        ];
    }
}
