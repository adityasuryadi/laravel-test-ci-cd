<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdvertisementResource;
use App\Services\AdvertisementService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use App\Http\Requests\AdvertisementCreateRequest;
use App\Http\Requests\AdvertisementUpdateRequest;
use App\Repositories\AdvertisementRepository;
use Illuminate\Support\Facades\Validator;

class AdvertisementController extends Controller
{
    private $advertisementService;
    private $advertisementRepository;

    public function __construct(AdvertisementService $advertisementService, AdvertisementRepository $advertisementRepository)
    {
        $this->advertisementService = $advertisementService;
        $this->advertisementRepository = $advertisementRepository;
    }

    public function index(): Response
    {
        $advertisements = $this->advertisementRepository->listAdvertisement();

        return inertia('Advertisement/Index', ['advertisements'=>$advertisements]);
    }

    public function create(): Response
    {
        return inertia('Advertisement/Create');
    }

    public function store(AdvertisementCreateRequest $request): RedirectResponse
    {
        $this->advertisementService->createAdvertisement($request);

        return redirect('advertisement');
    }

    public function edit($id): Response
    {
        $advertisement = $this->advertisementRepository->getAdvertisementById($id);
        return Inertia('Advertisement/Edit', ['advertisement'=>$advertisement]);
    }

    public function update($id, AdvertisementUpdateRequest $request): RedirectResponse
    {
        $this->advertisementService->updateAdvertisement($id, $request);

        return redirect('advertisement');
    }

    public function changeStatus(string $id)
    {
        $advertisement = $this->advertisementRepository->getAdvertisementById($id);
        $advertisement->update(['is_active'=> !$advertisement->is_active]);
    }

    public function view($id): Response
    {
        $advertisement = $this->advertisementRepository->getAdvertisementById($id);
        return Inertia('Advertisement/View', ['advertisement'=>$advertisement]);
    }

    public function getAds(Request $request)
    {

        $errors = Validator::make($request->all(), ['merchant_id'=>'required|numeric']);

        if ($errors->fails()) {
            return response()->json(['data'=>$errors->errors(),'response_status'=>'BAD REQUEST','response_code'=>400], 400);
        }

        try {
            $ads = $this->advertisementService->getAdsByMerchant($request);
            if ($ads != null) {
                return (new AdvertisementResource($ads))->additional(['response_status'=>'OK','response_code'=>200])->response()->setStatusCode(200);
            }
            return response()->json(['data'=>null,'response_status'=>'NOT FOUND','response_code'=>404], 404);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


}
