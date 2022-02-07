<?php

use App\Http\Controllers\Accounting\CashBankController;
use App\Http\Controllers\Accounting\JurnalController;
use App\Http\Controllers\Accounting\JurnalHistoryController;
use App\Http\Controllers\Advances\AdvanceReleaseController;
use App\Http\Controllers\Advances\AdvanceReportController;
use App\Http\Controllers\Generals\AccountController;
use App\Http\Controllers\Generals\CurrencyController;
use App\Http\Controllers\Generals\CategoryController;
use App\Http\Controllers\Generals\LedgerController;
use App\Http\Controllers\Generals\ServiceController;
use App\Http\Controllers\Reports\AdvanceManagements\AdvanceApproveController;
use App\Http\Controllers\Reports\AdvanceManagements\AdvanceRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {

    Route::get('dashboard', function() {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'masters'], function(){

        Route::resources([
            'currencies' => CurrencyController::class,
            'accounts'   => AccountController::class,
            'categories' => CategoryController::class,
            'ledgers'    => LedgerController::class,
            'services'   => ServiceController::class,
        ]);
        Route::get('accounts/{account_type}/next-account', [AccountController::class,'getAccountNo'])->name('accounts.next-account');
        Route::get('accounts/{account_type}/lists', [AccountController::class,'getAccountByType'])->name('accounts.lists');

    });

    Route::group(['prefix' => 'accounting'], function(){
        Route::resources([
            'jurnals' => JurnalController::class,
            'cash-banks' => CashBankController::class,
            'history-jurnals' => JurnalHistoryController::class,
        ]);

        Route::get('jurnals/{transaction_date}/next-transaction', [JurnalController::class,'getJurnalNo'])->name('jurnals.next-transaction');

    });

    Route::group(['prefix' => 'advance-management'], function(){
        Route::resources([
            'advance-requests' => AdvanceRequestController::class,
            'advance-approvals' => AdvanceApproveController::class,
            'advance-releases' => AdvanceReleaseController::class,
            'advance-reports' => AdvanceReportController::class,
        ]);
    });

    Route::group(['prefix' => 'settings'], function(){

    });
});
