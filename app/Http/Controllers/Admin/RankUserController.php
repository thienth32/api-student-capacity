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
                ->with([
                    'members' => function ($q) {
                        return $q->with('user', function ($q) {
                            return $q->with('contest_user');
                        });
                    }
                ])
                ->first())
                return response()->json(
                    [
                        'status' => false,
                        'payload' => 'Không tìm thấy chuyên ngành !'
                    ]
                );

            $users = [];
            $members = $major->members->unique()->toArray();

            foreach ($members as $member) {
                array_push($users, $member['user']);
            }
            if (!$ratingUser = $this->climbingRating(array_unique($users, SORT_REGULAR))) return response()->json(
                [
                    'status' => false,
                    'payload' => 'Có lỗi đã xảy ra !'
                ]
            );

            return response()->json([
                'status' => true,
                'payload' => $ratingUser,
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return response()->json([
                'status' => false,
                'payload' => 'Đã xảy ra lỗi !',
            ]);
        }
    }

    private function climbingRating($ranked)
    {
        try {
            $arrResult = $this->fomatRatingU($ranked, $this->getArrRankPoint($ranked));
            usort($arrResult, function ($a, $b) {
                return $a['rank_has'] <=> $b['rank_has'];
            });
            return $arrResult;
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return false;
        }
    }

    private function getArrRankPoint($ranked)
    {
        $arrRankPoint = [];
        foreach ($ranked as $rank) array_push($arrRankPoint, $rank['sum_point']);
        $arrRankPoint = array_unique($arrRankPoint);
        sort($arrRankPoint, SORT_NUMERIC);
        return $arrRankPoint;
    }

    private function fomatRatingU($ranked, $arrRankPoint)
    {
        $arrResult = [];
        foreach ($ranked as $rank) {
            foreach (array_reverse($arrRankPoint) as $kk => $pointRank) {
                if ($pointRank == $rank['sum_point']) array_push(
                    $arrResult,
                    $rank = array_merge($rank, [
                        'rank_has' => (int) $kk + 1
                    ])
                );
            };
        }
        return $arrResult;
    }
}