<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContestUser;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RankUserController extends Controller
{
    // Xep hang sinh vien theo chuyen nganh
    public function getRatingUser($slug)
    {
        try {
            if (!$major = Major::whereSlug($slug)
                ->first())
                return response()->json(
                    [
                        'status' => false,
                        'payload' => 'Không tìm thấy chuyên ngành ' . $slug . '!'
                    ]
                );
            $rank = 0;
            $maxPoin = 0;
            return response()->json([
                'status' => true,
                'payload' => $major
                    ->contest_user()
                    ->orderByDesc('reward_point')
                    ->with('contest')
                    ->get()
                    ->map(function ($q, $index) use (&$rank, &$maxPoin) {
                        if ($index == 0) $maxPoin = $q->reward_point; // **
                        if ($index == 0) $rank =  1; // **
                        if ($q->reward_point == $maxPoin) $rank = $rank; // **
                        if ($q->reward_point < $maxPoin) $rank += 1; // **
                        if ($q->reward_point < $maxPoin) $maxPoin = $q->reward_point; // **
                        return [
                            'user_name' => $q->user->name,
                            'rank' => $rank,
                            'reward_point' => $q->reward_point,
                            'contest_name' => $q->contest->name,
                            'contest' => $q->contest,
                            'user' => $q->user
                        ];
                    }),
            ]);
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            dd($th->getMessage());
            return response()->json([
                'status' => false,
                'payload' => 'Đã xảy ra lỗi !',
            ]);
        }
    }

    // private function climbingRating($ranked)
    // {
    //     try {
    //         $arrResult = $this->fomatRatingU($ranked, $this->getArrRankPoint($ranked));
    //         usort($arrResult, function ($a, $b) {
    //             return $a['rank_has'] <=> $b['rank_has'];
    //         });
    //         return $arrResult;
    //     } catch (\Throwable $th) {
    //         Log::info($th->getMessage());
    //         return false;
    //     }
    // }

    // private function getArrRankPoint($ranked)
    // {
    //     $arrRankPoint = [];
    //     foreach ($ranked as $rank) array_push($arrRankPoint, $rank['sum_point']);
    //     $arrRankPoint = array_unique($arrRankPoint);
    //     sort($arrRankPoint, SORT_NUMERIC);
    //     return $arrRankPoint;
    // }

    // private function fomatRatingU($ranked, $arrRankPoint)
    // {
    //     $arrResult = [];
    //     foreach ($ranked as $rank) {
    //         foreach (array_reverse($arrRankPoint) as $kk => $pointRank) {
    //             if ($pointRank == $rank['sum_point']) array_push(
    //                 $arrResult,
    //                 $rank = array_merge($rank, [
    //                     'rank_has' => (int) $kk + 1
    //                 ])
    //             );
    //         };
    //     }
    //     return $arrResult;
    // }
}