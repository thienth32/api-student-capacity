<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Modules\MContest\MContestInterface;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    use TResponse;

    public function __construct(public MContestInterface $contest)
    {
    }

    // public function support()
    // {
    //     $targetSupport = request('support_id');
    //     if($targetSupport == "at-odnd")
    //     {
    //         $data['arr'] = true;
    //         $data['data'] = $this->contest->getContestRunning();
    //     }else{
    //         $data =isset(config('support.supports')[$targetSupport]) ?
    //             config('support.supports')[$targetSupport] :
    //             config('support.supports')['excep'];
    //     }
    //     return $this->responseApi(true,$data);
    // }
}