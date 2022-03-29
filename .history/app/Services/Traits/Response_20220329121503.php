<?php

namespace App\Services\Traits;

trait Response
{
    function response($data, $code = 200)
    {
        return response()->json(
            $data,
            $code
        );
    }
}