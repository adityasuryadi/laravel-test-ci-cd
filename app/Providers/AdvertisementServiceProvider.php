<?php

namespace App\Providers;

use App\Repositories\AdvertisementDisplayDetailRepository;
use App\Repositories\AdvertisementRepository;
use App\Repositories\AdvertisementSummaryRepository;
use App\Services\AdvertisementService;
use App\Services\FileService;
use App\Services\Impl\AdvertisementServiceImpl;
use Illuminate\Support\ServiceProvider;

class AdvertisementServiceProvider extends ServiceProvider
{
    /**
    * Register services.
    *
    * @return void
    */
    public function register()
    {
        $this->app->singleton(AdvertisementService::class, function ($app) {
            return new AdvertisementServiceImpl($app->make(AdvertisementRepository::class), $app->make(AdvertisementDisplayDetailRepository::class), $app->make(FileService::class), $app->make(AdvertisementSummaryRepository::class));
        });
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
