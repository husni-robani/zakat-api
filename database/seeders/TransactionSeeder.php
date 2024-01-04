<?php

namespace Database\Seeders;

use App\Models\DonationType;
use App\Models\Donor;
use App\Models\GoodType;
use App\Models\Resident;
use App\Models\ServiceHour;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\TransactionService;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 4; $i++) {
            $transactions = Transaction::factory()->count(30)->make([
                'donation_types_id' => $i,
            ]);
            $transactions->each(function ($transaction) use ($i){
                $transactionData = $transaction->toArray();
                $transactionData['invoice_number'] = (new TransactionService())->generateInvoiceNumber($i);
                $transaction = Transaction::create($transactionData);
                if ($transaction->completed){
                    $transaction->wallet->addAmount($transaction->amount);
                }

            });
        }
    }
}
