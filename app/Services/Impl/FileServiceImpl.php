<?php

namespace App\Services\Impl;

use Illuminate\Support\Facades\Storage;
use App\Services\FileService;
use Illuminate\Http\UploadedFile;
use Image;

class FileServiceImpl implements FileService
{
    public function uploadImage(UploadedFile $file): string
    {
        $name = $file->getClientOriginalName();
        $extension = $file->extension();
        $saveName = sha1($name.date('Y-m-d H:i:s')).'.'.$extension;

        if(strtolower($extension) == 'gif') {
            $image = $file;
            Storage::put($saveName, file_get_contents($file));
        } else {
            $image = Image::make($file)->resize(900, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode($extension, 60);
            Storage::put($saveName, $image->stream(), 'public');
        }
        return $saveName;
    }
}
