<?php

namespace App\Repositories\Impl;

use App\Models\AdvertisementSummary;
use App\Repositories\AdvertisementSummaryRepository;

class AdvertisementSummaryRepositoryImpl implements AdvertisementSummaryRepository
{
    public function insert(array $payload)
    {
        $summary = AdvertisementSummary::firstOrNew([
            'advertisement_id'=>$payload['advertisement_id']
        ]);

        $summary->total_view  += $payload['duration'];
        $summary->save();
    }
}
