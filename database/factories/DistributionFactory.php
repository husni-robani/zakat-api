<?php

namespace Database\Factories;

use App\Models\Distribution;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Distribution>
 */
class DistributionFactory extends Factory
{
    protected $model = Distribution::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wallet = Wallet::inRandomOrder()->where('amount', '>', 0)->first();
        if ($wallet->good_types_id === 1){
            $amount = $wallet->amount <= 100 ? fake()->numberBetween(1, $wallet->amount) : fake()->numberBetween(1, 100);
        }else{
            $amount = $wallet->amount <= 1000000 ? fake()->numberBetween(1000, 1000000) : fake()->numberBetween(1000, $wallet->amount);
        }
        return [
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'title' => fake()->text(20),
            'description' => fake()->realText(50),
            'created_at' => fake()->dateTimeBetween($wallet->updated_at, now())
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Distribution $distribution){
            $distribution->wallet->amount -= $distribution->amount;
            $distribution->wallet->save();
        });
    }
}
