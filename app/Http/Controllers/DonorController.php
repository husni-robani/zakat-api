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
    public function index(){
        try {
            $donors = Donor::paginate();
        }catch (\Exception$exception ){
            return $this->responseFailed(
                'Failed to get all donor',
                400,
                $exception->getMessage()
            );
        }

        return DonorResource::collection($donors);
//        return $this->responseSuccess(
//            'Success to get all donor',
//            200,
//            DonorResource::collection($donors)
//        );
    }
}
