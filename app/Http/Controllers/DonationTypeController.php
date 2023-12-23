<?php

namespace App\Http\Controllers;

use App\Http\Resources\DonationTypeResource;
use App\Models\DonationType;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;

class DonationTypeController extends Controller
{
    use ApiResponses;
    public function index(){
        try {
            $donations = DonationType::all();
        }catch (\Exception $exception){
            return $this->responseFailed(
                'Failed to get all donations',
                400,
                $exception->getMessage()
            );
        }

        return DonationTypeResource::collection($donations);
    }

}
