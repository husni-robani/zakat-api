<?php

namespace Database\Factories;

use App\Models\Donor;
use App\Models\ServiceHour;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $good_types_id = $this->faker->randomElement([1, 2]);
        $donationTypes = [1, 2, 3, 4];
        $amount = $good_types_id == 1
            ? $this->faker->numberBetween(1, 1000)
            : $this->faker->numberBetween(1000, 999999999);
        $walletsId = Wallet::where('good_types_id', $good_types_id)->where('donation_types_id', $donationTypes)->firstOrFail();
        $donors_id = Donor::factory()->count(1)->create();

        return [
            'good_types_id' => $good_types_id,
            'donation_types_id' => $this->faker->randomElement($donationTypes),
            'description' => $this->faker->paragraphs(5, true),
            'amount' => $amount,
            'completed' => $this->faker->boolean(),
            'wallets_id' => $walletsId,
            'service_hours_id' => ServiceHour::inRandomOrder()->first(),
            'donors_id' => $donors_id->value('id')
        ];


    }

    public function configure()
    {
        return $this->afterCreating(function (Transaction $transaction){
            if ($transaction->completed){
                $transaction->wallet->amount += $transaction->amount;
                $transaction->wallet->save();
            }
        });
    }
}
