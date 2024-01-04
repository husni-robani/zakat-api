<?php

namespace App\Http\Controllers;

use App\Http\Resources\DistributionResource;
use App\Models\Distribution;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;
class DistributionController extends Controller
{
    use ApiResponses;
    public function index(Request $request){

        try {
            //paginate, wallet
            $distribution = Distribution::query();

            $distribution->when($request->query('wallet_id') != null, function ($query) use ($request){
                $query->where('wallet_id', $request->get('wallet_id'));
            });

            $distribution = $request->get('paginate') == 'true' ? $distribution->paginate() : $distribution->get();
        }catch (\Exception $exception){
            return $this->responseFailed(
                'failed to get distribution',
                404,
                $exception->getMessage()
            );
        }
        return DistributionResource::collection($distribution);
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'string',
            'amount' => 'required|integer',
            'wallet_id' => 'required',
            'description' => 'string'
        ]);

        try {
            $distribution = Wallet::findOrFail($request->get('wallet_id'))->distributions()->create($request->except('wallet_id'));
            if ($request->hasFile('image')){
                $distribution->addMediaFromRequest('images')
                    ->toMediaCollection();
            }
        }catch (\Exception $exception){
            return $this->responseFailed(
                'failed to store new distribution',
                404,
                $exception->getMessage()
            );
        }

        return (new DistributionResource($distribution));
    }
}
