<?php

namespace App\Services\Impl;

use App\Repositories\AdvertisementRepository;
use App\Services\AdvertisementService;
use Illuminate\Http\Request;

class AdvertisementServiceImpl implements AdvertisementService
{
    private $advertisementRepository;
    public function __construct(AdvertisementRepository $advertisementRepository)
    {
        $this->advertisementRepository = $advertisementRepository;
    }

    public function createAdvertisement(Request $request)
    {
        try {
            $payload = $request->all();
            $this->advertisementRepository->Insert($payload);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
