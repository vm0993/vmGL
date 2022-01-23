<?php

namespace App\Providers;

use App\Interfaces\AppInterface;
use App\Repositories\CurrenciesRepository;
use App\Repositories\LedgerRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind(AppInterface::class, CurrenciesRepository::class);
        //$this->app->bind(AppInterface::class, LedgerRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
