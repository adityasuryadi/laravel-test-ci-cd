<?php

namespace App\Repositories\Impl;

use App\Models\Advertisement;
use App\Repositories\AdvertisementRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\Builder;

class AdvertisementRepositoryImpl implements AdvertisementRepository
{
    public function Insert(array $payload)
    {
        DB::transaction(function () use ($payload) {
            $advertisement = Advertisement::create($payload);
            $advertisement->advertisementDisplay()->createMany($payload["merchants"]);
        });
    }

    public function Update(string $id, array $payload)
    {
        $advertisement = Advertisement::with(['advertisementDisplay'])->find($id);
        $advertisement->update($payload);

        if(isset($payload['merchants'])) {
            $advertisement->advertisementDisplay()->createMany($payload["merchants"]);
        }
    }

    public function deleteAdvertisementDisplay(string $advertisementId)
    {
        $advertisement = Advertisement::with(['advertisementDisplay'])->find($advertisementId);
        $advertisement->advertisementDisplay()->delete();
    }

    // query untuk get iklan terakhir by merchant id
    public function getAdvertisementDisplayByMerchant(string $merchantId)
    {
        $ads = Advertisement::whereHas('advertisementDisplay', function (Builder $query) use ($merchantId) {
            $query->where('merchant_id', $merchantId);
        })
        ->where('is_active', 1)
        ->select('id', 'name', 'source_url', 'duration')
        ->orderBy('last_display', 'ASC')
        ->first();
        return $ads;
    }
}
