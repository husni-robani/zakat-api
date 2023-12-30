<?php

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
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
    Route::post('/residents', [\App\Http\Controllers\ResidentController::class, 'store']);
    Route::delete('/residents/{no_kk}', [\App\Http\Controllers\ResidentController::class, 'destroy']);
    Route::patch('/residents/{no_kk}', [\App\Http\Controllers\ResidentController::class, 'update']);

    Route::get('/guests', [\App\Http\Controllers\GuestController::class, 'index']);
    Route::get('/donors', [\App\Http\Controllers\DonorController::class, 'index']);

    Route::get('/transactions', [\App\Http\Controllers\TransactionController::class, 'index']);
    Route::post('/transactions/completed/{id_transaction}', [\App\Http\Controllers\TransactionController::class, 'transactionCompleted']);

    Route::post('/service-hours', [\App\Http\Controllers\ServiceHourController::class, 'store']);

    Route::get('/history/transactions', [\App\Http\Controllers\HistoryController::class, 'historyTransaction']);

    Route::get('/export/fitrah', [\App\Http\Controllers\ExportSheetController::class, 'fidyahReport']);
    Route::get('/export', [\App\Http\Controllers\ExportSheetController::class, 'overallReport']);
});


Route::get('/residents/all/{paginated?}', [\App\Http\Controllers\ResidentController::class, 'index']);
Route::post('/guests', [\App\Http\Controllers\GuestController::class, 'store']);
Route::post('/transactions/create', [\App\Http\Controllers\TransactionController::class, 'store']);
Route::get('/residents/{no_kk}', [\App\Http\Controllers\ResidentController::class, 'show']);
Route::get('/donations', [\App\Http\Controllers\DonationTypeController::class, 'index']);
Route::get('/service-hours', [\App\Http\Controllers\ServiceHourController::class, 'index']);

Route::get('/test', function (){
//   return \App\Models\Donor::where('donorable_type', 'App\Models\Guest')->first()->donorable;
//   return Transaction::with('donor.donorable', 'goodType', 'donationType')->get();
//    return (new \App\Services\TransactionReport())->fitrahResidentTransactions();
});





