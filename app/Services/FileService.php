<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

interface FileService
{
    public function uploadImage(UploadedFile $file): string;
}
