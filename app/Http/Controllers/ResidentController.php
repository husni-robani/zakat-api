<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResidentRequest;
use App\Http\Requests\UpdateResidentRequest;
use App\Http\Resources\ResidentResource;
use App\Models\Resident;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;

class ResidentController extends Controller
{
    use ApiResponses;
    public function index(?bool $paginated = false){
        try {
            $residents = Resident::when($paginated, function () {
                return Resident::paginate();
            }, function (){
                return Resident::all();
            });
        }catch (ModelNotFoundException | \Exception $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
                'erros' => [
                    $exception->getMessage()
                ]
            ]);
        }
        return ResidentResource::collection($residents);
    }

    public function store(StoreResidentRequest $request){
        try {
            $resident = Resident::create($request->all());
        }catch (\Exception $exception){
            return $this->responseFailed(
                'Create resident failed',
                400,
                $exception->getMessage()
            );
        }
        return new ResidentResource($resident);
    }

    public function show($house_number){
        try {
            $resident = Resident::where('house_number', $house_number)->firstOrFail();
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'failed',
                404,
                $exception->getMessage()
            );
        }
        return new ResidentResource($resident);
    }

    public function destroy($no_kk){
        try {
            Resident::where('no_kk', $no_kk)->firstOrFail()->delete();
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                "failed to delete resident",
                400,
                $exception->getMessage()
            );
        }
        return response(null, 204);
    }

    public function update(UpdateResidentRequest $request, $no_kk){
        try {
            $resident = Resident::where('no_kk', $no_kk)->firstOrFail();
            $resident->update($request->all());
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                "failed to update resident",
                400,
                $exception->getMessage()
            );
        }

        return new ResidentResource($resident);
    }
}
