<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Round;
use App\Services\Modules\MRound\MRoundInterface;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    use TResponse;
    public function __construct(private MRoundInterface $round)
    {
    }

    public function indexApi($id_round)
    {
        try {
            $data = $this->round->results($id_round);
            if (!$data) throw new \Exception("Không tìm thấy lịch sử ");
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }

    public function index($id_round)
    {
        $round = $this->round->find($id_round);
        $teams = $this->round->getTeamByRoundId($id_round);
        return view('pages.round.detail.result.index', compact('round', 'teams'));
    }
}