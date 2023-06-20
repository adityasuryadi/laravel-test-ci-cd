<?php

namespace App\Providers;

use App\Repositories\AdvertisementRepository;
use App\Repositories\Impl\AdvertisementRepositoryImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AdvertisementRepositoryProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        AdvertisementRepository::class => AdvertisementRepositoryImpl::class,
    ];

    public function provides()
    {
        return [AdvertisementRepository::class];
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
