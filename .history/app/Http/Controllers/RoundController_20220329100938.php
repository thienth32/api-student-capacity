<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RoundController extends Controller
{
    private $round;

    public function __construct(Round $round)
    {
        $this->round = $round;
    }

    /**
     *  Get list round
     */
    private function getList()
    {
        try {
            $data = $this->round::search(request('q') ?? null, ['name', 'description'])
                ->sort((request('sort') == 'desc' ? 'desc' : 'asc'), request('sort_by') ?? null, 'rounds')
                ->hasReuqest([
                    'contest_id' => request('contest_id') ?? null,
                    'type_exam_id' => request('type_exam_id') ?? null,
                ])
                ->with([
                    'contest',
                    'type_exam',
                ])
                ->paginate(request('limit') ?? 10);
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //  View round
    public function index()
    {
        if (!($data = $this->getList())) return view('not_found');
        $data = $this->getList();
        return view('', ['rounds' => $data]);
    }

    //  Response round
    public function apiIndex()
    {

        if (!($data = $this->getList())) return response()->json([
            "status" => false,
            "payload" => "Server not found",
        ], 404);
        return response()->json([
            "status" => true,
            "payload" => $data,
        ], 200);
    }
    /**
     *  End list round
     */

    /**
     *  Update round
     */

    private function updateRound($id)
    {
        try {
            if (!($round = $this->round::find($id))) return false;

            $data = null;
            if (request()->has('image')) {
                $validator  =  Validator::make(
                    request()->all(),
                    [
                        'image' => 'image|max:10000'
                    ],
                    [
                        'image.max' => 'Resize image !',
                        'image.image' => 'Invalid image !',
                    ]
                );
                if ($validator->fails()) return [
                    'status' => false,
                    'errors' => $validator,
                ];
                // Delete image
                Storage::disk('google')->delete($round->image);
                $nameFile = request()->image->getClientOriginalName();
                Storage::disk('google')->putFileAs("", request()->image, $nameFile);
                $data = array_merge(request()->except('image'), [
                    'image' => $nameFile
                ]);
            } else {
                $data = request()->all();
            }
            $round->update($data);
            return $round;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // View round
    public function update($id)
    {
        if ($data = $this->updateRound($id)) {
            if ($data !== true || $data['status']) return redirect()->back()->withErrors($data['errors']);
            return redirect('');
        }

        return redirect('error');
    }
    // Response round
    public function apiUpdate($id)
    {
        if ($data = $this->updateRound($id)) {
            if (isset($data['status']) && $data['status'] == false) return response()->json([
                "status" => false,
                "payload" => $data['errors']->errors(),
            ]);
            return response()->json([
                "status" => true,
                "payload" => $data,
            ]);
        }


        return response()->json([
            "status" => false,
            "payload" => "Server not found",
        ], 404);
    }
    /**
     * End update round
     */

    /**
     * Destroy round
     */

    private function destroyRound($id)
    {
        try {
            $data = $this->round::find($id);
            $data->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // View round
    public function destroy($id)
    {
        if ($this->destroyRound($id)) return redirect('');
        return redirect('error');
    }

    // Response
    public function apiDestroy($id)
    {
        if ($this->destroyRound($id))  return response()->json([
            "status" => true,
            "payload" => "Success"
        ]);
        return response()->json([
            "status" => false,
            "payload" => "Server not found"
        ], 404);
    }
    /**
     *  End destroy round
     */
}