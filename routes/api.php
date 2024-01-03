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

    Route::get('/guests/all/{paginated?}', [\App\Http\Controllers\GuestController::class, 'index']);
    Route::get('/donors/all/{paginated?}', [\App\Http\Controllers\DonorController::class, 'index']);

    Route::get('/transactions/all/{paginated?}', [\App\Http\Controllers\TransactionController::class, 'index']);
    Route::post('/transactions/completed/{invoice_number}', [\App\Http\Controllers\TransactionController::class, 'transactionCompleted']);

    Route::post('/service-hours', [\App\Http\Controllers\ServiceHourController::class, 'store']);
    Route::post('/service-hours/set-available', [\App\Http\Controllers\ServiceHourController::class, 'setAvailableServiceHour']);

    Route::get('/history/transactions/all/{paginated?}', [\App\Http\Controllers\HistoryController::class, 'historyTransaction']);

    Route::get('/export/donation', [\App\Http\Controllers\ExportSheetController::class, 'donationReport']);
});


Route::get('/residents/all/{paginated?}', [\App\Http\Controllers\ResidentController::class, 'index']);
Route::post('/guests', [\App\Http\Controllers\GuestController::class, 'store']);
Route::post('/transactions/create', [\App\Http\Controllers\TransactionController::class, 'store']);
Route::get('/residents/{house_number}', [\App\Http\Controllers\ResidentController::class, 'show']);
Route::get('/donations', [\App\Http\Controllers\DonationTypeController::class, 'index']);
Route::get('/service-hours', [\App\Http\Controllers\ServiceHourController::class, 'index']);

Route::get('/test', function (){
    return  Transaction::where('donation_types_id', 3)
            ->whereYear('updated_at', now()->year)
            ->get()->count();

});





