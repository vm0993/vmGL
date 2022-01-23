<?php

use App\Http\Controllers\Accounting\CashBankController;
use App\Http\Controllers\Accounting\JurnalController;
use App\Http\Controllers\Accounting\JurnalHistoryController;
use App\Http\Controllers\Generals\AccountController;
use App\Http\Controllers\Generals\CurrencyController;
use App\Http\Controllers\Generals\CategoryController;
use App\Http\Controllers\Generals\LedgerController;
use App\Http\Controllers\Generals\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {

    Route::get('dashboard', function() {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'masters'], function(){

        Route::resource('currencies',CurrencyController::class);
        Route::resource('categories',CategoryController::class);
        Route::group(['prefix' => 'accounts'], function(){
            Route::get('/', [AccountController::class,'index'])->name('accounts.index');
            Route::get('/create', [AccountController::class,'create'])->name('accounts.create');
            Route::post('/create', [AccountController::class,'store'])->name('accounts.store');
            Route::get('/{id}', [AccountController::class,'edit'])->name('accounts.edit');
            Route::put('/{id}', [AccountController::class,'update'])->name('accounts.update');
            //get Next Account
            Route::get('/{account_type}/next-account', [AccountController::class,'getAccountNo'])->name('accounts.next-account');
            Route::get('/{account_type}/lists', [AccountController::class,'getAccountByType'])->name('accounts.lists');
        });
        Route::resource('ledgers',LedgerController::class);
        Route::resource('services',ServiceController::class);
    });

    Route::group(['prefix' => 'accounting'], function(){
        Route::group(['prefix' => 'jurnals'], function(){
            Route::get('/', [JurnalController::class,'index'])->name('jurnals.index');
            Route::get('/create', [JurnalController::class,'create'])->name('jurnals.create');
            Route::post('/create', [JurnalController::class,'store'])->name('jurnals.store');
            Route::get('/{id}', [JurnalController::class,'edit'])->name('jurnals.edit');
            Route::put('/{id}', [JurnalController::class,'update'])->name('jurnals.update');
            //get Next Number
            Route::get('/{transaction_date}/next-account', [JurnalController::class,'getAccountNo'])->name('accounts.next-account');
        });
        Route::get('jurnals', [JurnalController::class,'index'])->name('accounting.jurnals');
        Route::get('cash-banks', [CashBankController::class,'index'])->name('accounting.cash-banks');
        Route::get('history-jurnals', [JurnalHistoryController::class,'index'])->name('accounting.history-jurnals');
    });

    Route::group(['prefix' => 'advance-management'], function(){
        Route::get('advance-requests', [CurrencyController::class,'index'])->name('advance-management.advance-requests');
        Route::get('advance-approvals', [CategoryController::class,'index'])->name('advance-management.advance-approvals');
        Route::get('advance-releases', [AccountController::class,'index'])->name('advance-management.advance-releases');
        Route::get('advance-reports', [LedgerController::class,'index'])->name('advance-management.advance-reports');
    });

    Route::group(['prefix' => 'settings'], function(){

    });
});
