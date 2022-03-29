<?php

namespace App\Services\Traits;

trait TResponse
{
    function responseApi($data, $code = 200)
    {
        return response()->json(
            $data,
            $code
        );
    }
}