<?php

namespace App\Services;

use App\Models\Donor;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class TransactionService
{
    public function createTransaction(Request $request, Donor $donor) : Transaction
    {
        $wallet = Wallet::where(['donation_types_id' => $request->get('donation_types_id'), 'good_types_id' => $request->get('good_types_id')])->firstOrFail();
        $transaction = $donor->transactions()->create([
            'amount' => $request->get('amount'),
            'description' => $request->get('description_transaction'),
            'donation_types_id' => $request->get('donation_types_id'),
            'good_types_id' => $request->get('good_types_id'),
            'wallets_id' => $wallet->id
        ]);

        return $transaction;
    }

    /**
     * @throws \Exception
     */
    public function makeCompletedStatusTrue(Transaction $transaction) : Transaction
    {
        if ($transaction->completed) {
            throw new \Exception('transaction already completed');
        }
        $transaction->update([
            'completed' => true
        ]);
        $transaction->wallet->addAmount($transaction->amount);
        return $transaction;
    }
}
