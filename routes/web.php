<?php

use App\Http\Livewire\GeneralLedgers\Currency;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('tmp');
});

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/

/*Route::group( ['middleware' => ['auth:sanctum','verified']], function() {
    Route::group(['prefix' => '/'], function() {
        Route::resource('dashboard', DashboardController::class);  
    });
});*/

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {
    Route::get('/dashboard', function() {
        return view('dashboard');
    })->name('dashboard');

    Route::get('currency', Currency::class)->name('currency'); //Tambahkan routing ini
});
