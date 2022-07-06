<?php

namespace App\Services\Traits;

trait TResponse
{
    function responseApi($status= false,$data = "Not found", $code = 200)
    {
        if(!$status) $code = 404;
        if(!$status) $data = [  'status' => $status  , 'message' => $data ];
        if($status) $data = [ 'status' => $status  , 'payload' => $data];
        return response()->json(
            $data,
            $code
        );
    }
}
