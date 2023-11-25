<?php

namespace Database\Seeders;

use App\Models\DonationType;
use App\Models\Donor;
use App\Models\GoodType;
use App\Models\Resident;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $transaction = new Transaction();
//        $transaction->amount = 15000000;
//        $transaction->description = null;
//        $transaction->donation_types_id = DonationType::first()->id;
//        $transaction->donors_id = Donor::first()->id;
//        $transaction->wallets_id = Wallet::first()->id;
//        $transaction->good_types_id = GoodType::first()->id;
//        $transaction->save();
//
//        $transaction->wallet->amount += $transaction->amount;
//        $transaction->wallet->save();

        $transaction = Transaction::create([
            'amount' => 15000000,
            'donation_types_id' => DonationType::first()->id,
            'donors_id' => Donor::first()->id,
            'wallets_id' => Wallet::first()->id,
            'good_types_id' => GoodType::first()->id
        ]);

        Wallet::find($transaction->wallets_id)->update([
            'amount' => 15000000
        ]);
    }
}
