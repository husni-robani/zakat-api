<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionCollection;
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
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    use ApiResponses;
    public function index(){
        try {
            $transactions = Transaction::query()->paginate();
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'Failed to get all transaction',
                400,
                $exception->getMessage()
            );
        }
        return TransactionResource::collection($transactions);
    }

    public function storeResidentTransaction(StoreTransactionRequest $request, DonorService $donorService, TransactionService $transactionService){
        try {
            $resident = Resident::where('no_kk', $request->route()->parameter('no_kk'))->firstOrFail();
            $donor = $donorService->createResidentDonor($request, $resident);
            $transaction = $transactionService->createTransaction($request, $donor);
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'Create transaction failed',
                400,
                $exception->getMessage()
            );
        }

        return $this->responseSuccess(
            'create transaction success',
            201,
            new TransactionResource($transaction)
        );
    }

    public function storeGuestTransaction(StoreTransactionRequest $request, DonorService $donorService, TransactionService $transactionService){
        try {
            $donor  = $donorService->createGuestDonor($request, Guest::create(['description' => $request->get('description_guest')]));
        }catch (\Exception $exception){
            return $this->responseFailed(
                'Create transaction failed',
                400,
                $exception->getMessage()
            );
        }

        return $this->responseSuccess(
            'Create transaction success',
            201,
            new TransactionResource($transactionService->createTransaction($request, $donor))
        );
    }

    public function transactionCompleted($id_transaction, TransactionService $transactionService){
        try {
            $transaction = Transaction::findOrFail($id_transaction);
            $transactionService->makeCompletedStatusTrue($transaction);
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'Completed transaction failed',
                400,
                $exception->getMessage()
            );
        }

        return $this->responseSuccess(
            'Completed transaction success',
            201,
            ''
        );
    }
}
