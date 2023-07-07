<?php

namespace App\Repositories\Impl;

use App\Models\Advertisement;
use App\Repositories\AdvertisementRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AdvertisementRepositoryImpl implements AdvertisementRepository
{
    public function Insert(array $payload): void
    {
        DB::transaction(function () use ($payload) {
            $advertisement = Advertisement::create($payload);
            $advertisement->advertisementDisplay()->createMany($payload["merchants"]);
        });
    }

    public function Update(string $id, array $payload): void
    {
        $advertisement = Advertisement::with(['advertisementDisplay'])->find($id);
        $advertisement->update($payload);

        if(isset($payload['merchants'])) {
            $advertisement->advertisementDisplay()->createMany($payload["merchants"]);
        }
    }

    public function deleteAdvertisementDisplay(string $advertisementId): void
    {
        $advertisement = Advertisement::with(['advertisementDisplay'])->find($advertisementId);
        $advertisement->advertisementDisplay()->delete();
    }

    // query untuk get iklan terakhir by merchant id
    public function getAdvertisementDisplayByMerchant(string $merchantId): Advertisement
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

    public function getAdvertisementById(string $advertiementId): Advertisement
    {
        $ads = Advertisement::find($advertiementId);
        return $ads;
    }

    public function listAdvertisement(): Collection
    {
        $advertisements = Advertisement::with('advertisementDisplay')->get();
        return $advertisements;
    }
}
