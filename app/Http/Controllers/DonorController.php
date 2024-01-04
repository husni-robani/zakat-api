<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonorRequest;
use App\Http\Resources\DonorResource;
use App\Models\Donor;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;

class DonorController extends Controller
{
    use ApiResponses;
    public function index(Request $request){
        try {
            $donors = Donor::query();
            $donors->when($request->query('type') === 'resident', function ($query){
                $query->where('donorable_type', 'App\Models\Resident');
            });

            $donors->when($request->query('type') === 'guest', function ($query) {
                $query->where('donorable_type', 'App\Models\Guest');
            });

            $donors->when($request->query('q'), function ($query) use ($request){
                $query->where('name', 'like', '%' . $request->query('q') . '%')
                    ->orWhere(function ($query) use ($request){
                        $query->whereHasMorph('donorable', ['App\Models\Resident'], function ($query) use ($request){
                            $query->where('house_number', 'like', '%' . $request->query('q') . '%');
                        });
                    });
            });


            $donors = $request->query('paginated') ? $donors->paginate($request->query('paginated')) : $donors->get();
        }catch (\Exception$exception ){
            return $this->responseFailed(
                'Failed to get all donor',
                400,
                $exception->getMessage()
            );
        }
        return DonorResource::collection($donors);
    }
}
