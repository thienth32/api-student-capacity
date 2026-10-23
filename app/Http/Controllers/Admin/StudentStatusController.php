<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;

class StudentStatusController extends Controller
{
    //
    use TResponse;

    public function index()
    {
        $response = collect(config('util.CANDIDATE_OPTIONS.STUDENT_STATUSES'))
            ->map(function ($item, $key) {
                return [
                    'key' => $key,
                    'value' => $item,
                ];
            });
        return $this->responseApi(true, $response);
    }
}
