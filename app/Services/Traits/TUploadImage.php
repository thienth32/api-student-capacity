<?php

namespace App\Services\Traits;


use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait TUploadImage
{
    function uploadFile($file, $nameOld = null)
    {
        try {

            if ($nameOld) if (Storage::disk('google')->has($nameOld)) Storage::disk('google')->delete($nameOld);

            // $img = Image::make($file);
            // $img->resize(100, 100, function ($constraint) {
            //     $constraint->aspectRatio();
            // });
            // return  $img;
            // $file =  Image::make($file->getRealPath())->resize(50, 50)->stream();
            $nameFile = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();

            Storage::disk('google')->putFileAs('', $file, $nameFile);
            return $nameFile;
        } catch (\Throwable $th) {
            return false;
        }
    }
}