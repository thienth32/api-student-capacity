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

    protected function saveImgBase64($param, $nameOld = null)
    {
        try {
            if (!$param) return false;
            if ($nameOld) if (Storage::disk('s3')->has($nameOld)) Storage::disk('s3')->delete($nameOld);
            list($extension, $content) = explode(';', $param);
            $tmpExtension = explode('/', $extension);
            preg_match('/.([0-9]+) /', microtime(), $m);
            $fileName = sprintf('img%s%s.%s', date('YmdHis'), $m[1], $tmpExtension[1]);
            $content = explode(',', $content)[1];
            $storage = Storage::disk('s3');
            $storage->put('' . $fileName, base64_decode($content));
            return $fileName;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
