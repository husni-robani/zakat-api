<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestRequest;
use App\Http\Resources\GuestResource;
use App\Models\Guest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;

class GuestController extends Controller
{
    use ApiResponses;
    public function index(Request $request){
        try {
            $guests = Guest::all();
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'Failed to get guests',
                400,
                $exception->getMessage()
            );
        }
        return $this->responseSuccess(
            'Success to get guests',
            200,
            GuestResource::collection($guests)
        );
    }

    public function store(StoreGuestRequest $request){
        try {
            $guest = Guest::create($request->all());
        }catch (\Exception $exception){
            return $this->responseFailed(
                'Failed to create new guest',
                400,
                $exception->getMessage()
            );
        }

        return $this->responseSuccess(
            'Success to create new guest',
            '201',
            new GuestResource($guest)
        );
    }
}
