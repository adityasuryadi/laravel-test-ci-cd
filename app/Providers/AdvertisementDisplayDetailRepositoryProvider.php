<?php

namespace App\Providers;

use App\Repositories\Impl\AdvertisementDisplayDetailRepositoryImpl;
use App\Repositories\AdvertisementDisplayDetailRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AdvertisementDisplayDetailRepositoryProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        AdvertisementDisplayDetailRepository::class => AdvertisementDisplayDetailRepositoryImpl::class,
    ];

    public function provides()
    {
        return [AdvertisementDisplayDetailRepository::class];
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
