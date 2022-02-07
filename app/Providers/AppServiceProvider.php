<?php

namespace App\Providers;

use App\Models\Accounting\CashBanks\CashBankDetail;
use App\Models\Accounting\Jurnals\JurnalDetail;
use App\Observers\Accountings\CashBankDetailObserver;
use App\Observers\Accountings\JurnalDetailObserver;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /* $this->app->bind(
            'App\Repositories\AppInterface',
            'App\Repositories\Accounting\CurrenciesRepository',
        ); */
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Paginator::useBootstrap();
        if(session()->get('applocale') != null){
            Carbon::setLocale(session()->get('applocale'));
        }else{
            Carbon::setLocale('us');
        }
        Broadcast::routes(['middleware' => ['web.auth']]);
        require base_path('routes/channels.php');
        //config(['app.locale' => 'id']);
        //Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        Schema::defaultStringLength(191);
        Blade::withoutDoubleEncoding();

        //Observer Accounting Module
        JurnalDetail::observe(JurnalDetailObserver::class);
        CashBankDetail::observe(CashBankDetailObserver::class);

        //Advance Management Module
        
    }
}
