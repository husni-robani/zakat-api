<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceHourRequest;
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
            $serviceHours = ServiceHour::all();
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'get service hours failed',
                404,
                $exception->getMessage()
            );
        }
        return ServiceHourResource::collection($serviceHours);
    }

    public function store(StoreServiceHourRequest $request){
        try {
            $serviceHour = ServiceHour::create($request->toArray());
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'failed to create new service hour',
                404,
                $exception->getMessage()
            );
        }

        return new ServiceHourResource($serviceHour);
    }
}
