<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CkeditorController extends Controller
{
    use TUploadImage;
    public function updoadFile(Request $request)
    {
        $nameFile = $this->uploadFile($request->upload);
        return response()->json([
            'fileName' => $nameFile,
            'uploaded' => 1,
            'url' => Storage::disk('s3')->temporaryUrl($nameFile, now()->addDays(7)),
        ]);
    }
}