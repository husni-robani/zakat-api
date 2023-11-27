<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->group(function (){
    Route::get('/residents', [\App\Http\Controllers\ResidentController::class, 'index']);
    Route::post('/residents', [\App\Http\Controllers\ResidentController::class, 'store']);
    Route::delete('/residents/{no_kk}', [\App\Http\Controllers\ResidentController::class, 'destroy']);
    Route::patch('/residents/{no_kk}', [\App\Http\Controllers\ResidentController::class, 'update']);

    Route::get('/guests', [\App\Http\Controllers\GuestController::class, 'index']);
    Route::post('/guests', [\App\Http\Controllers\GuestController::class, 'store']);
});

Route::get('/residents/{no_kk}', [\App\Http\Controllers\ResidentController::class, 'show']);
