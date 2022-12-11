<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Modules\MContest\MContestInterface;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    use TResponse;

    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        return view('pages.support.index', $data);
    }
}
