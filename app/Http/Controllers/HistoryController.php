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
    public function historyTransaction(Request $request){
        try {
            $history = Transaction::query();

            $history->when($request->query('q'), function ($query) use ($request){
                $query->where('invoice_number', 'like', '%'.$request->query('q').'%')
                    ->orWhereHas('donor', function ($query) use ($request){
                        $query->where('name', 'like', '%'.$request->query('q').'%')
                            ->orWhereHasMorph('donorable', ['App\Models\Resident'], function ($query) use ($request){
                                $query->where('house_number', 'like', '%' . $request->query('q') . '%')
                                    ->orWhere('no_kk', 'like', '%' . $request->query('q') . '%');
                            });
                    });
            });

            $history->when($request->query('good_type_id'), fn($query) => $query->where('good_types_id', $request->query('good_type_id')));

            $history->when($request->query('donation_type_id'), fn($query) => $query->where('donation_types_id', $request->query('donation_type_id')));

            $history->when($request->query('wallet_id'), fn($query) => $query->where('wallets_id', $request->query('wallet_id')));

            $history->when($request->query('donor_type') === 'resident', function ($query) use ($request){
                $query->whereHas('donor', function ($query) use ($request){
                   $query->where('donorable_type', 'App\Models\Resident');
                });
            });

            $history->when($request->query('donor_type') === 'guest', function ($query) use ($request){
                $query->whereHas('donor', function ($query) use ($request){
                    $query->where('donorable_type', 'App\Models\Guest');
                });
            });

            $history = $request->query('paginated') ? $history->orderByDesc('created_at')->paginate($request->query('paginated')) : $history->orderByDesc('created_at')->get();

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
