<?php

namespace App\Services\Traits;

use Illuminate\Support\Facades\Storage;

trait TUploadImage
{
    function uploadFile($file, $nameOld = null, $resize = null)
    {
        try {
            if ($nameOld) if (Storage::disk('google')->has($nameOld)) Storage::disk('google')->delete($nameOld);
            $nameFile = uniqid() . '-' . time() . '_img.' . $file->getClientOriginalExtension();
            Storage::disk('google')->putFileAs('', $file, $nameFile);
            return $nameFile;
        } catch (\Throwable $th) {
            return false;
        }
    }
}