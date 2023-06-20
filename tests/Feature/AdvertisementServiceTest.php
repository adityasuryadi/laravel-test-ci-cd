<?php

namespace Tests\Feature;

use App\Services\AdvertisementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}
