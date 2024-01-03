<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Mail\TransactionCompleted;
use App\Models\Donor;
use App\Models\Guest;
use App\Models\Resident;
use App\Models\Transaction;
use App\Services\DonorService;
use App\Services\TransactionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    use ApiResponses;
    public function index(Request $request){
        try {
            $transactions = Transaction::query();

            $transactions->when($request->query('status') === 'completed', function ($query) {
                $query->where('completed', true);
            });

            $transactions->when($request->query('status') === 'uncompleted', function ($query) {
                $query->where('completed', false);
            });

            $transactions->when($request->query('timeframe') === 'weekly', function ($query) {
                $last_week = Carbon::now()->subWeek();
                $query->where('created_at', '>=', $last_week);
            });

            $transactions->when($request->query('timeframe') === 'monthly', function ($query) {
                $last_month = Carbon::now()->subMonth();
                $query->where('created_at', '>=', $last_month);
            });
             $transactions = $request->get('paginate') == 'true' ? $transactions->paginate() : $transactions->get();


        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'Failed to get all transaction',
                400,
                $exception->getMessage()
            );
        }
        return TransactionResource::collection($transactions);
    }
    public function store(StoreTransactionRequest $request, DonorService $donorService, TransactionService $transactionService){
        try {
            if($request->get('donorType') == 1){
                $resident = Resident::where('house_number', $request->get('house_number'))->firstOrFail();
                $donor = $donorService->createResidentDonor($request, $resident);
            }else{
                $donor = $donorService->createGuestDonor($request, Guest::create(['description' => $request->get('description_guest')]));
            }
            $transaction = $transactionService->createTransaction($request, $donor);
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'Create transaction failed',
                400,
                $exception->getMessage()
            );
        }
        return new TransactionResource($transaction);

    }

    public function transactionCompleted($invoice_number, TransactionService $transactionService){
        try {
            $transaction = Transaction::where('invoice_number', $invoice_number)->firstOrFail();
            $transactionService->makeCompletedStatusTrue($transaction);
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'Completed transaction failed',
                400,
                $exception->getMessage()
            );
        }

        return response(null, 204);
    }
}
