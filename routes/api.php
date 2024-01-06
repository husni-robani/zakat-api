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
    Route::delete('/residents/{house_number}', [\App\Http\Controllers\ResidentController::class, 'destroy']);
    Route::patch('/residents/{house_number}', [\App\Http\Controllers\ResidentController::class, 'update']);

    Route::get('/guests/all/{paginated?}', [\App\Http\Controllers\GuestController::class, 'index']);
    Route::get('/donors/all/{paginated?}', [\App\Http\Controllers\DonorController::class, 'index']);

    Route::get('/transactions', [\App\Http\Controllers\TransactionController::class, 'index']);
    Route::post('/transactions/completed/{invoice_number}', [\App\Http\Controllers\TransactionController::class, 'transactionCompleted']);

    Route::post('/service-hours', [\App\Http\Controllers\ServiceHourController::class, 'store']);
    Route::post('/service-hours/set-available', [\App\Http\Controllers\ServiceHourController::class, 'setAvailableServiceHour']);

    Route::get('/history/transactions/all/{paginated?}', [\App\Http\Controllers\HistoryController::class, 'historyTransaction']);

    Route::get('/export/donation', [\App\Http\Controllers\ExportSheetController::class, 'donationReport']);

    Route::delete('/distributions/{distributionId}', [\App\Http\Controllers\DistributionController::class, 'destroy']);

    Route::delete('/media/{mediaId}', [\App\Http\Controllers\MediaController::class, 'destroy']);
});


Route::get('/residents/all/{paginated?}', [\App\Http\Controllers\ResidentController::class, 'index']);
Route::post('/guests', [\App\Http\Controllers\GuestController::class, 'store']);
Route::post('/transactions/create', [\App\Http\Controllers\TransactionController::class, 'store']);
Route::get('/residents/{house_number}', [\App\Http\Controllers\ResidentController::class, 'show']);
Route::get('/donations', [\App\Http\Controllers\DonationTypeController::class, 'index']);
Route::get('/service-hours', [\App\Http\Controllers\ServiceHourController::class, 'index']);

Route::get('/distributions', [\App\Http\Controllers\DistributionController::class, 'index']);
Route::post('/distributions', [\App\Http\Controllers\DistributionController::class, 'store']);

Route::get('/media/{mediaId}', [\App\Http\Controllers\MediaController::class, 'show']);

Route::get('/info', function (){
   return response([
       'donation_type' => \App\Models\DonationType::all(),
       'good_type' => \App\Models\GoodType::all(),
       'wallet' => \App\Models\Wallet::select(['id', 'name', 'amount', 'donation_types_id', 'good_types_id'])->get()
   ], 200);
});

Route::post('/test', function (Request $request){

    \App\Models\Distribution::first()
        ->addMediaFromRequest('image')
        ->toMediaCollection();

    return \App\Models\Distribution::first()->getMedia();
});
Route::get('/test', function (Request $request){
   return \Spatie\MediaLibrary\MediaCollections\Models\Media::find(1);
});





