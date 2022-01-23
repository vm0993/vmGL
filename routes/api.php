<?php

use App\Http\Controllers\Accounting\CurrencyController as AccountingCurrencyController;
use App\Http\Controllers\Api\v1\Accounting\CurrencyController;
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

Route::get('currency', [CurrencyController::class,'index']);

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

/* Route::middleware('auth:sanctum')->group(function () {
    Route::get('currency',[AccountingCurrencyController::class,'index']);
});
 */