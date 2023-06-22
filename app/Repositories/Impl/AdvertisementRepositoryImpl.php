<?php

namespace App\Repositories\Impl;

use App\Models\Advertisement;
use App\Repositories\AdvertisementRepository;
use Illuminate\Support\Facades\DB;

class AdvertisementRepositoryImpl implements AdvertisementRepository
{
    public function Insert(array $payload)
    {
        DB::transaction(function () use ($payload) {
            $advertisement = Advertisement::create($payload);
            $advertisement->advertisementDisplay()->createMany($payload["merchants"]);
        });
    }
}
