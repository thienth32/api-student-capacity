<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Round;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    protected function getList($id_round)
    {

        $query = Round::find($id_round)
            ->teams()
            ->with('result', function ($q) use ($id_round) {
                return $q->where('round_id', $id_round)->orderBy('point', 'desc')->sort((request('sort') == 'desc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'results')

                    ->orderBy('created_at', 'asc');
            })
            ->search(request('q') ?? null, ['name']);


        return $query;
    }
    public function indexApi($id_round)
    {
        $data = $this->getList($id_round)->paginate(request('limit') ?? 6);
        // $data = $this->getList($id_round);
        // dd($data->toArray());
        return response()->json([
            'status' => true,
            'payload' => $data
        ]);
    }
    public function index($id_round)
    {
        $round = Round::find($id_round);
        $results = $this->getList($id_round)->paginate(request('limit') ?? 10);
        return view('pages.round.detail.result.index', compact('round', 'results'));
    }
}