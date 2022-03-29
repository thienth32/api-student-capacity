<?php

namespace App\Services\Traits;

trait Response
{
    function responseApi($data, $code = 200)
    {
        return response()->json(
            $data,
            $code
        );
    }
}