<?php

namespace App\Services;

use App\Mail\TransactionCompleted;
use App\Models\Donor;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

        if ($transaction->donor->email){
            $this->sendingEmailToDonor($transaction->donor->email);
        }
        $transaction->wallet->addAmount($transaction->amount);
        return $transaction;
    }

    private function sendingEmailToDonor($email){
        Mail::to($email)->send(new TransactionCompleted());
    }
}
