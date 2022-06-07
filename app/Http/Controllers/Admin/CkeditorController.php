<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class CkeditorController extends Controller
{
    use TUploadImage;
    public function updoadFile(Request $request)
    {
        $nameFile = $this->uploadFile($request->upload);
    }
}