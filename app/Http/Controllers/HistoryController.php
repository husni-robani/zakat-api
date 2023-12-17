<?php

namespace App\Http\Controllers;

use App\Http\Resources\HistoryResource;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    use ApiResponses;
    public function historyTransaction(){
        try {
            $history = Transaction::with('wallet', 'goodType', 'donationType', 'donor.donorable')->paginate(10);
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'get history transcation failed',
                400,
                $exception->getMessage()
            );
        }
        return HistoryResource::collection($history);
    }
}
