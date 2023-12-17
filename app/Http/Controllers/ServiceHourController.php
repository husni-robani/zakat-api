<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceHourResource;
use App\Models\ServiceHour;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;

class ServiceHourController extends Controller
{
    use ApiResponses;
    public function index(){
        try {
            $serviceHours = ServiceHourResource::collection(ServiceHour::all());
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'get service hours failed',
                404,
                $exception->getMessage()
            );
        }
        return $this->responseSuccess(
            'get service hours success',
            200,
            $serviceHours
        );
    }
}
