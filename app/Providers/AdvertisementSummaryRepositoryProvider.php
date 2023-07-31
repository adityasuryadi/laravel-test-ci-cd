<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AdvertisementSummaryRepository;
use App\Repositories\Impl\AdvertisementSummaryRepositoryImpl;

class AdvertisementSummaryRepositoryProvider extends ServiceProvider
{
    public array $singletons = [
        AdvertisementSummaryRepository::class => AdvertisementSummaryRepositoryImpl::class,
    ];

    public function provides()
    {
        return [AdvertisementSummaryRepository::class];
    }

    /**
     * Register any application services.
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
