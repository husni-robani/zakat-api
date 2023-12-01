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
    Route::get('/donors', [\App\Http\Controllers\DonorController::class, 'index']);

    Route::get('/transactions', [\App\Http\Controllers\TransactionController::class, 'index']);
    Route::post('/transactions/create/{no_kk}', [\App\Http\Controllers\TransactionController::class, 'storeResidentTransaction']);
    Route::post('/transactions/create', [\App\Http\Controllers\TransactionController::class, 'storeGuestTransaction']);
    Route::post('/transactions/completed/{id_transaction}', [\App\Http\Controllers\TransactionController::class, 'transactionCompleted']);
});

Route::get('/residents/{no_kk}', [\App\Http\Controllers\ResidentController::class, 'show']);
Route::get('/donations', [\App\Http\Controllers\DonationTypeController::class, 'index']);




