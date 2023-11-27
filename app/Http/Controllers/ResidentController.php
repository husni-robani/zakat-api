<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResidentRequest;
use App\Http\Resources\ResidentResource;
use App\Models\Resident;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;

class ResidentController extends Controller
{
    use ApiResponses;
    public function index(){
        try {
            $residents = ResidentResource::collection(Resident::all());
        }catch (ModelNotFoundException | \Exception $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
                'erros' => [
                    $exception->getMessage()
                ]
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'get all residents success',
            'data' => $residents
        ]);
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

        return $this->responseSuccess(
            'success create new resident',
            201,
            new ResidentResource($resident)
        );
    }

    public function show($no_kk){
        try {
            $resident = Resident::where('no_kk', $no_kk)->firstOrFail();
        }catch (ModelNotFoundException | \Exception $exception){
            return $this->responseFailed(
                'failed',
                404,
                $exception->getMessage()
            );
        }

        return $this->responseSuccess(
            "success",
            200,
            new ResidentResource($resident)
        );
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

        return $this->responseSuccess(
            "success to delete resident",
            204,
            ''
        );
    }

    public function update(Request $request, $no_kk){
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

        return $this->responseSuccess(
            'Success to update resident',
            201,
            new ResidentResource($resident)
        );
    }
}
