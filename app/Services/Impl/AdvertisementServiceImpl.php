<?php

namespace App\Services\Impl;

use App\Repositories\AdvertisementRepository;
use App\Services\AdvertisementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

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

            // dd($image->stream());

            Storage::put($saveName, $image->stream(), 'public');

            return response()->json([
                'data' => [
                    'error' => false,
                    'file_name' => $saveName,
                ],
            ]);

            // $this->advertisementRepository->Insert($payload);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
