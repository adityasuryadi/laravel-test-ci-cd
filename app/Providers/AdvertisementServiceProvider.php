<?php

namespace App\Providers;

use App\Services\AdvertisementService;
use App\Services\Impl\AdvertisementServiceImpl;
use Illuminate\Support\ServiceProvider;

class AdvertisementServiceProvider extends ServiceProvider
{
    public array $singletons = [
        AdvertisementService::class => AdvertisementServiceImpl::class
    ];

    public function provides()
    {
        return [AdvertisementService::class];
    }
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
        //
    }
}
