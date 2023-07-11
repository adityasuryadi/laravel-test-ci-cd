<?php

namespace App\Repositories;

use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Collection;

interface AdvertisementRepository
{
    public function Insert(array $payload): void;
    public function Update(string $id, array $payload): void;
    public function deleteAdvertisementDisplay(string $advertisementId): void;
    public function getAdvertisementDisplayByMerchant(string $merchantId): ?Advertisement;
    public function getAdvertisementById(string $advertiementId): Advertisement;
    public function listAdvertisement(): Collection;
}
