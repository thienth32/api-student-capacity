<?php

namespace App\Services\Traits;


use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait TUploadImage
{
    function uploadFile($file, $nameOld = null)
    {
        try {

            if (!$file) return false;
            if ($nameOld) if (Storage::disk('s3')->has($nameOld)) Storage::disk('s3')->delete($nameOld);
            $nameFile = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('s3')->putFileAs('', $file, $nameFile);
            return $nameFile;
        } catch (\Throwable $th) {
            return false;
        }
    }
}