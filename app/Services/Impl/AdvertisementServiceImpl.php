<?php

namespace App\Services\Impl;

use App\Models\Advertisement;
use App\Repositories\AdvertisementRepository;
use App\Services\AdvertisementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Facades\DB;

class AdvertisementServiceImpl implements AdvertisementService
{
    private $advertisementRepository;
    public function __construct(AdvertisementRepository $advertisementRepository)
    {
        $this->advertisementRepository = $advertisementRepository;
    }

    public function createAdvertisement(Request $request)
    {
        try {
            $payload = $request->all();

            $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $extension = $file->extension();
            $saveName = sha1($name.date('Y-m-d H:i:s')).'.'.$extension;

            $image = Image::make($file)->resize(900, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('png', 60);

            Storage::put($saveName, $image->stream(), 'public');
            $payload["source_url"] = $saveName;

            $this->advertisementRepository->Insert($payload);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateAdvertisement(string $id, Request $request)
    {
        try {
            DB::transaction(function () use ($id, $request) {
                $advertisement = Advertisement::find($id);
                $payload = $request->all();
                $file = $request->file('image');
                $merchants = [];
                $payload['source_url'] = $advertisement->source_url;

                if ($file) {
                    $name = $file->getClientOriginalName();
                    $extension = $file->extension();
                    $saveName = sha1($name.date('Y-m-d H:i:s')).'.'.$extension;
                    $image = Image::make($file)->resize(900, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode('png', 60);
                    Storage::put($saveName, $image->stream(), 'public');
                    $payload["source_url"] = $saveName;
                }

                foreach ($request->merchants as $value) {
                    array_push($merchants, ['merchant_id'=>$value]);
                }

                $payload['merchants'] = $merchants;

                // delete display relation
                $this->advertisementRepository->deleteAdvertisementDisplay($id);

                $this->advertisementRepository->Update($id, $payload);
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
