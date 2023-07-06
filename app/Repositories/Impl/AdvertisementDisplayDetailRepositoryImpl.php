<?php

namespace App\Repositories\Impl;

use App\Repositories\AdvertisementDisplayDetailRepository;
use App\Models\Advertisement;

class AdvertisementDisplayDetailRepositoryImpl implements AdvertisementDisplayDetailRepository
{
    public function Insert(Advertisement $advertisement, array $payload)
    {
        $advertisement->advertisementDisplayDetail()->create($payload);
    }
}
