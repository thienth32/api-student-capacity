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
                return $q->where('round_id', $id_round)
                    ->orderBy('point', 'desc')
                    ->orderBy('created_at', 'asc');
            })
            ->sort((request('sort') == 'desc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'results')
            ->search(request('q') ?? null, ['name']);


        return $query;
    }
    public function indexApi($id_round)
    {
        $data = $this->getList($id_round)->paginate(request('limit') ?? 10);

        return response()->json([
            'status' => true,
            'payload' => $data
        ]);
    }
    public function index($id_round)
    {
        $round = Round::find($id_round);
        $teams = $this->getList($id_round)->paginate(request('limit') ?? 10);
        // dd($teams);
        return view('pages.round.detail.result.index', compact('round', 'teams'));
    }
}