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
            // search : title
            // filter : wallet_id, donation_type_id, good_type_id
            $distribution = Distribution::query();

            $distribution->when($request->query('q') != null, function ($query) use ($request){
                $query->where('title', 'like' , '%'.$request->get('q').'%');
            });

            $distribution->when($request->query('donation_type_id') != null, function ($query) use ($request){
                $query->whereHas('wallet', function ($query) use ($request){
                    $query->whereHas('donationType', function ($query) use ($request){
                        $query->where('id', $request->get('donation_type_id'));
                    });
                });
            });

            $distribution->when($request->query('good_type_id') != null, function ($query) use ($request){
                $query->whereHas('wallet', function ($query) use ($request){
                    $query->whereHas('goodType', function ($query) use ($request){
                        $query->where('id', $request->get('good_type_id'));
                    });
                });
            });


            $distribution->when($request->query('wallet_id') != null, function ($query) use ($request){
                $query->where('wallet_id', $request->get('wallet_id'));
            });

            $distribution = $request->get('paginate') != null ? $distribution->paginate($request->query('paginate')) : $distribution->orderByDesc('created_at')->get();
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
            'title' => 'string|required',
            'amount' => 'required|integer',
            'donation_type_id' => 'required|integer',
            'good_type_id' => 'required|integer',
            'description' => 'string',
            'link' => 'string'
        ]);

        try {
            $wallet = Wallet::where('donation_types_id', $request->get('donation_type_id'))
                ->where('good_types_id', $request->get('good_type_id'))
                ->firstOrFail();
            $distribution = $wallet->distributions()->create($request->except('donation_type_id', 'good_type_id'));
            $distribution->wallet->reduceAmount($distribution->amount);
            if ($request->hasFile('image')){
                $distribution->addMediaFromRequest('image')
                    ->usingFileName('DISTRIBUSI-' . $distribution->wallet->donationType->name . '-' . $distribution->created_at->format('Y-m-d'))
                    ->usingName($distribution->wallet->donationType->name . ' ' . $distribution->created_at->format('Y-m-d'))
                    ->withCustomProperties([
                        'wallet' => $distribution->wallet->name
                    ])
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

    public function destroy($distributionId){
        try {
            Distribution::findOrFail($distributionId)->delete();
        }catch (\Exception $exception){
            return $this->responseFailed(
                'Failed to delete distribution',
                404,
                $exception->getMessage()
            );
        }

        return response('', 204);
    }
}
