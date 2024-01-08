<?php

namespace App\Services;

use App\Http\Resources\TransactionResource;
use App\Mail\TransactionCompletedMail;
use App\Mail\TransactionInvoiceMail;
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
            'wallets_id' => $wallet->id,
            'invoice_number' => $this->generateInvoiceNumber($request->get('donation_types_id'))
        ]);
        $this->sendInvoiceEmailToDonor($transaction->donor->email, new TransactionResource($transaction));
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
            $this->sendCompletedEmailToDonor($transaction->donor->email, $transaction);
        }
        $transaction->wallet->addAmount($transaction->amount);
        return $transaction;
    }

    private function sendCompletedEmailToDonor($email, Transaction $transaction){
        Mail::to($email)->send(new TransactionCompletedMail(new TransactionResource($transaction)));
    }
    private function sendInvoiceEmailToDonor($email, TransactionResource $transactionResource){
        Mail::to($email)->send(new TransactionInvoiceMail($transactionResource));
    }

    public function generateInvoiceNumber($donationTypeId) : string{
        //INV-FTR-2024-1
        $uniqueNumber = Transaction::where('donation_types_id', $donationTypeId)
                ->whereYear('updated_at', now()->year)
                ->get()->count() + 1;
        return match ($donationTypeId) {
            1 => 'INV-FTR-' . now()->year . '-' . $uniqueNumber,
            2 => 'INV-MAL-' . now()->year . '-' . $uniqueNumber,
            3 => 'INV-FDY-' . now()->year . '-' . $uniqueNumber,
            4 => 'INV-SDK-' . now()->year . '-' . $uniqueNumber,
            default => 'INV-' . now()->year . '-' . $uniqueNumber,
        };
    }
}
