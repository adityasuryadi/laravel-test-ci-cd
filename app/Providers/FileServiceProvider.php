<?php

namespace App\Providers;

use App\Services\FileService;
use App\Services\Impl\FileServiceImpl;
use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider
{
    public array $singletons = [
        FileService::class => FileServiceImpl::class,
    ];

    public function provides()
    {
        return [FileService::class];
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
