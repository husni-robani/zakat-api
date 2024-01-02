<?php

namespace Database\Factories;

use App\Models\Donor;
use App\Models\ServiceHour;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\TransactionService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{

    protected $model = Transaction::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $good_types_id = $this->faker->randomElement([1, 2]);
        $donationTypeId = $this->faker->randomElement([1, 2, 3, 4]);
        $amount = $good_types_id == 1
            ? $this->faker->numberBetween(1, 1000)
            : $this->faker->numberBetween(1000, 999999999);
        $walletsId = Wallet::where('good_types_id', $good_types_id)->where('donation_types_id', $donationTypeId)->firstOrFail();
        $donors_id = Donor::factory()->count(1)->create();
        $date = $this->faker->dateTimeBetween('-4 years', 'now');
        static $counter = 1;
        return [
            'invoice_number' => $this->generateInvoiceNumber($donationTypeId, $counter++, $date),
            'good_types_id' => $good_types_id,
            'donation_types_id' => $donationTypeId,
            'description' => $this->faker->sentence(5),
            'amount' => $amount,
            'completed' => $this->faker->boolean(),
            'wallets_id' => $walletsId,
            'donors_id' => $donors_id->value('id'),
            'created_at' => $date
        ];


    }
    public function generateInvoiceNumber($donationTypeId, $uniqueNumber, $date) : string{
        return match ($donationTypeId) {
            1 => 'INV-FTR-' . $date->format('Y') . '-' . $uniqueNumber,
            2 => 'INV-MAL-' . $date->format('Y') . '-' . $uniqueNumber,
            3 => 'INV-FDY-' . $date->format('Y') . '-' . $uniqueNumber,
            4 => 'INV-SDK-' . $date->format('Y') . '-' . $uniqueNumber,
            default => 'INV-' . $date->format('Y') . '-' . $uniqueNumber,
        };
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
