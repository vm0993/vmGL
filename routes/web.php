<?php

use App\Http\Controllers\TenantsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/404-tenant', 'template.not-found')->name('404.tenant');

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    // Routes
    Route::get('dashboard',[\App\Http\Controllers\DashboardController::class,'index'])->name('dashboard');
    Route::patch('/update-token', [App\Http\Controllers\DashboardController::class, 'saveToken'])->name('store-token');
    Route::post('/send-notification', [App\Http\Controllers\DashboardController::class, 'sendNotification'])->name('send.notification');
    
    Route::group(['prefix' => 'masters'], function(){

        Route::resources([
            'departments'    => \App\Http\Controllers\Generals\DepartmentController::class,
            'currencies'     => \App\Http\Controllers\Generals\CurrencyController::class,
            'accounts'       => \App\Http\Controllers\Generals\AccountController::class,
            'categories'     => \App\Http\Controllers\Generals\CategoryController::class,
            'ledgers'        => \App\Http\Controllers\Generals\LedgerController::class,
            'services'       => \App\Http\Controllers\Generals\ServiceController::class,
            'units'          => \App\Http\Controllers\Generals\UnitController::class,
            'taxes'          => \App\Http\Controllers\Generals\TaxController::class,
            'personels'      => \App\Http\Controllers\Generals\PersonelController::class,
        ]);
        Route::get('accounts/{account_type}/next-account', [\App\Http\Controllers\Generals\AccountController::class,'getAccountNo'])->name('accounts.next-account');
        Route::get('accounts/{account_type}/lists', [\App\Http\Controllers\Generals\AccountController::class,'getAccountByType'])->name('accounts.lists');

        Route::get('services/{type}/lists', [\App\Http\Controllers\Generals\ServiceController::class,'getItemChargeByType'])->name('services.lists');

    });

    Route::group(['prefix' => 'keuangan'], function(){
        Route::resources([
            'jurnals'         => \App\Http\Controllers\Accounting\JurnalController::class,
            'cash-banks'      => \App\Http\Controllers\Accounting\CashBankController::class,
            'history-jurnals' => \App\Http\Controllers\Accounting\JurnalHistoryController::class,
        ]);

        Route::get('jurnals/{transaction_date}/next-transaction', [\App\Http\Controllers\Accounting\JurnalController::class,'getJurnalNo'])->name('jurnals.next-transaction');
        Route::get('jurnals/{id}/get-transaction', [\App\Http\Controllers\Accounting\JurnalController::class,'getTransaction'])->name('jurnals.get-transaction');

        Route::get('cash-banks/{transaction_date}/next-transaction/{type}/type', [\App\Http\Controllers\Accounting\CashBankController::class,'getCashBankNo'])->name('cash-banks.next-transaction');
        Route::get('cash-banks/{id}/get-transaction', [\App\Http\Controllers\Accounting\CashBankController::class,'getTransaction'])->name('cash-banks.get-transaction');

    });

    Route::group(['prefix' => 'operasional'], function(){
        Route::resources([
            'advance-requests'  => \App\Http\Controllers\Advances\AdvanceRequestController::class,
            'advance-approvals' => \App\Http\Controllers\Advances\AdvanceApprovalController::class,
            'advance-releases'  => \App\Http\Controllers\Advances\AdvanceReleaseController::class,
            'advance-reports'   => \App\Http\Controllers\Advances\AdvanceReportController::class,
        ]);

        Route::get('advance-requests/{transaction_date}/next-transaction', [\App\Http\Controllers\Advances\AdvanceRequestController::class,'getRequestNo'])->name('advance-requests.next-transaction');
        Route::get('advance-requests/{id}/get-transaction', [\App\Http\Controllers\Advances\AdvanceRequestController::class,'getTransaction'])->name('advance-requests.get-transaction');
        //submit request
        Route::patch('advance-requests/{id}/submit', [\App\Http\Controllers\Advances\AdvanceRequestController::class,'submitRequestAdvance'])->name('advance-requests.submit-request');
        //aprove request
        Route::patch('advance-requests/{id}/approve', [\App\Http\Controllers\Advances\AdvanceRequestController::class,'getTransaction'])->name('advance-requests.approve-request');
        //getRequestNo
        Route::get('advance-approvals/{id}/get-transaction', [\App\Http\Controllers\Advances\AdvanceApprovalController::class,'getTransaction'])->name('advance-approvals.get-transaction');
        Route::get('advance-approvals/{advance_approval}/approval', [\App\Http\Controllers\Advances\AdvanceApprovalController::class,'approveRequest'])->name('advance-approvals.approval');
    });

    Route::group(['prefix' => 'settings'], function(){
        Route::resources([
            'company'  => \App\Http\Controllers\Settings\CompanyController::class,
            'approval' => \App\Http\Controllers\Settings\ApprovalController::class,
            'roles'    => \App\Http\Controllers\Settings\RoleController::class,
            'users'    => \App\Http\Controllers\Settings\UserController::class,
        ]);
    });

});
