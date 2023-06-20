<?php

namespace Tests\Feature;

use App\Repositories\AdvertisementRepository;
use Tests\TestCase;

class AdvirtesementRepositoryTest extends TestCase
{
    private AdvertisementRepository $advertisementRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->advertisementRepository = $this->app->make(AdvertisementRepository::class);
    }

    public function testAdvertisementNotNull()
    {
        self::assertNotNull($this->advertisementRepository);
    }
}
