<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use App\Services\AdvertisementService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use App\Models\AdvertisementDisplayDetail;

class AdvertisementController extends Controller
{
    private $advertisementService;

    public function __construct(AdvertisementService $advertisementService)
    {
        $this->advertisementService = $advertisementService;
    }

    public function index(): Response
    {
        $advertisements = Advertisement::with('advertisementDisplay')->get();
        return inertia('Advertisement/Index', ['advertisements'=>$advertisements]);
    }

    public function create(): Response
    {
        return inertia('Advertisement/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name'=>'required',
            'duration'=>'required',
            'image'=>'required|image',
            'merchants'=>'required|array|min:1'
        ]);

        $this->advertisementService->createAdvertisement($request);

        return redirect('advertisement');
    }

    public function edit($id): Response
    {
        $advertisement = Advertisement::with('advertisementDisplay')->findOrFail($id);
        return Inertia('Advertisement/Edit', ['advertisement'=>$advertisement]);
    }

    public function update($id, Request $request): RedirectResponse
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

    public function changeStatus(string $id)
    {
        $advertisement = Advertisement::with('advertisementDisplay')->findOrFail($id);
        $advertisement->update(['is_active'=> !$advertisement->is_active]);
    }

    public function view($id)
    {
        $advertisement = Advertisement::with('advertisementDisplay')->findOrFail($id);
        return Inertia('Advertisement/View', ['advertisement'=>$advertisement]);
    }

    public function getAds(Request $request): JsonResponse
    {

        try {
            $ads = $this->advertisementService->getAdsByMerchant($request);
            return (new AdvertisementResource($ads))->additional(['response_status'=>'OK','response_code'=>200])->response()->setStatusCode(200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


}
