<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\{
    ArchieveContract
};
use App\Services\{
    ArchieveService
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
        $this->app->singleton(ArchieveContract::class, ArchieveService::class);
    }
}
