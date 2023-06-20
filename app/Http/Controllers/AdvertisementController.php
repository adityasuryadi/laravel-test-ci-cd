<?php

namespace App\Http\Controllers;

use App\Services\AdvertisementService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdvertisementController extends Controller
{
    private $advertisementService;

    public function __construct(AdvertisementService $advertisementService)
    {
        $this->advertisementService = $advertisementService;
    }

    public function create()
    {
        return inertia('Advertisement/Create');
    }

    public function store(Request $request)
    {
        $this->advertisementService->createAdvertisement($request);
    }
}
