<?php

namespace Tests\Feature;

use App\Repositories\AdvertisementSummaryRepository;
use Tests\TestCase;

class AdvertisementSummaryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private AdvertisementSummaryRepository $advertismentSummaryRepository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->advertismentSummaryRepository = $this->app->make(AdvertisementSummaryRepository::class);
    }

    public function test_advertisment_summary_repository_not_null()
    {
        self::assertNotNull($this->advertismentSummaryRepository);
    }
}
