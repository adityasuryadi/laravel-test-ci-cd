<?php

namespace App\Repositories\Impl;

use App\Models\Advertisement;
use App\Repositories\AdvertisementRepository;

class AdvertisementRepositoryImpl implements AdvertisementRepository
{
    public function Insert(array $payload)
    {
        Advertisement::create($payload);
    }
}
