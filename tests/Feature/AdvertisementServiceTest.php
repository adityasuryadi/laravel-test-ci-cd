<?php

namespace Tests\Feature;

use App\Services\AdvertisementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Advertisement;

class AdvertisementServiceTest extends TestCase
{
    private AdvertisementService $advertisementService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->advertisementService = $this->app->make(AdvertisementService::class);
    }

    public function testAdvertisementNotNull()
    {
        self::assertNotNull($this->advertisementService);
    }

    // public function testGetAds()
    // {
    //     $ads= \App\Models\Advertisement::where('merchants->merchant_id', 30)->get();
    //     dd($ads);
    // }
}
