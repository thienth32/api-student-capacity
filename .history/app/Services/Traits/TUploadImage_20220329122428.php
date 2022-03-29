<?php

namespace App\Services\Traits;

use Illuminate\Support\Facades\Storage;

trait TUploadImage
{
    function uploadFile($file)
    {
        try {
            $nameFile = uniqid() . '-' . time() . '_img.' . $file->getClientOriginalExtension();
            Storage::disk('google')->putFileAs('', $file, $nameFile);
            return $nameFile;
        } catch (\Throwable $th) {
            return false;
        }
    }
}