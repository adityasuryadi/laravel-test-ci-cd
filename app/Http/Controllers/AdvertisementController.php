<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
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

    public function index()
    {
        $advertisements = Advertisement::with('advertisementDisplay')->get();
        return inertia('Advertisement/Index', ['advertisements'=>$advertisements]);
    }

    public function create()
    {
        return inertia('Advertisement/Create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'duration'=>'required',
            'image'=>'required|image',
            'merchants'=>'required|array|min:1'
        ]);

        $this->advertisementService->createAdvertisement($request);
    }

    public function edit($id)
    {
        $advertisement = Advertisement::with('advertisementDisplay')->findOrFail($id);
        return Inertia('Advertisement/Edit', ['advertisement'=>$advertisement]);
    }

    public function update($id, Request $request)
    {
        $validationRules = [
            'name'=>'required',
            'duration'=>'required|numeric',
            'merchants'=>'required|array|min:1'
        ];
        if($request->file('image')) {
            $validationRules['image'] = 'required|image';
        }
        $this->validate($request, $validationRules);
        $this->advertisementService->updateAdvertisement($id, $request);

        return redirect('advertisement');
    }


}
