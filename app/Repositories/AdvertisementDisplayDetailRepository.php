<?php

namespace App\Repositories;

use App\Models\Advertisement;

interface AdvertisementDisplayDetailRepository
{
    public function Insert(Advertisement $advertisement, array $payload);
}
