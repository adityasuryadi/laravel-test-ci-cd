<?php

namespace Tests\Feature;

use App\Services\AdvertisementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Advertisement;
use App\Repositories\AdvertisementRepository;
use Illuminate\Http\Request;
use Mockery;
use Mockery\Mock;
use Mockery\MockInterface;

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

    public function test_get_ads_by_merchant_id_not_found(): void
    {

        $request =  $this->instance(Request::class, Mockery::mock(Request::class, function (MockInterface $mock) {
            $mock->makePartial();
            $mock->shouldReceive('all')->andReturn(['merchant_id'=>100000]);
        }));

        self::assertNull($this->advertisementService->getAdsByMerchant($request));
    }
}
