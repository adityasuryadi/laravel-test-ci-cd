<?php

namespace App\Repositories;

interface AdvertisementRepository
{
    public function Insert(array $payload);
    public function Update(string $id, array $payload);
    public function deleteAdvertisementDisplay(string $advertisementId);
    public function getAdvertisementDisplayByMerchant(string $merchantId);
}
