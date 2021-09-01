<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\{
    AchieveContract
};
use App\Services\{
    AchieveService
};

class ContractServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(AchieveContract::class, AchieveService::class);
    }
}
