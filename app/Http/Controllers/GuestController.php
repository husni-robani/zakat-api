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
            $guests = Guest::paginate();
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'Failed to get guests',
                400,
                $exception->getMessage()
            );
        }
        return GuestResource::collection($guests);}

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
        return new GuestResource($guest);
    }
}
