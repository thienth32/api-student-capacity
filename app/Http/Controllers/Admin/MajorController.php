<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    use TResponse;
    private $major;
    public function __construct(Major $major)
    {
        $this->major = $major;
    }

    private function getMajor($slug)
    {
        try {
            $major = $this->major::where('slug', $slug);
            return $major;
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function addCollectionMajor($major)
    {
        try {
            return $major->withCount('contests');
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function apiShow($slug)
    {
        if (!($major = $this->getMajor($slug))) return $this->responseApi(
            [
                'status' => false,
                'payload' => 'Không tìm thấy major '
            ]
        );
        if (!($major = $this->addCollectionMajor($major))) return $this->responseApi(
            [
                'status' => false,
                'payload' => 'Không lấy được major '
            ]
        );
        return $this->responseApi([
            'status' => true,
            'payload' => $major->first(),
        ]);
    }
}