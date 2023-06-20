<?php

namespace App\Services;

use Illuminate\Http\Request;

interface AdvertisementService
{
    public function createAdvertisement(Request $request);
}
