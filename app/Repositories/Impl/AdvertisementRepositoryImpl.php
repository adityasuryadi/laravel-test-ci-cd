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

    public function Update(string $id, array $payload)
    {
        $advertisement = Advertisement::with(['advertisementDisplay'])->find($id);
        $advertisement->name = $payload['name'];
        $advertisement->duration = $payload['duration'];
        $advertisement->source_url = $payload['source_url'];
        $advertisement->is_active = $payload['is_active'];
        $advertisement->save();

        $advertisement->advertisementDisplay()->createMany($payload["merchants"]);
    }

    public function deleteAdvertisementDisplay(string $advertisementId)
    {
        $advertisement = Advertisement::with(['advertisementDisplay'])->find($advertisementId);
        $advertisement->advertisementDisplay()->delete();
    }
}
