<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
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
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    use ApiResponses;
    public function index(bool $paginated = false){
        try {
            $transactions = Transaction::when($paginated, function (){
                return Transaction::with('donor', 'donationType', 'goodType', 'wallet')->paginate();

            }, function (){
                return Transaction::with('donor', 'donationType', 'goodType', 'wallet')->get();
            });
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
                $resident = Resident::where('no_kk', $request->get('no_kk'))->firstOrFail();
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

        return response(null, 204);
    }
}
