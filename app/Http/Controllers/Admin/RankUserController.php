<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Skill;
use App\Models\Contest;
use App\Models\Question;
use Illuminate\Support\Str;
use App\Services\Traits\TResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\ResultCapacity;
use App\Models\Round;
use App\Models\User;
use App\Services\Modules\MMajor\MMajorInterface;

class RankUserController extends Controller
{
    public function __construct(private MMajorInterface $major)
    {
    }
    use TResponse;
    /**
     * @OA\Get(
     *     path="/api/public/rating/major-contest/{slug}",
     *     description="Description api contest rank",
     *     tags={"Rank user" , "User" , "Major"  ,"Rank_contest"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug chuyên ngành ",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }"),
     * )
     */
    // Xep hang sinh vien theo chuyen nganh
    public function getRatingUser(MMajorInterface $majorModel, $slug)
    {
        try {
            $dataRating = $majorModel->getRatingUserByMajorSlug($slug);
            if ($dataRating === false) throw new \Exception('Không tìm thấy chuyên ngành ' . $slug . '!');
            return $this->responseApi(
                true,
                $dataRating
            );
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
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

    /**
     * @OA\Get(
     *     path="/api/public/rating/major-capacity/{slug}",
     *     description="Description api api capacity rank",
     *     tags={"Rank user" , "User" , "Major" ,"Rank_capacity"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug chuyên ngành ",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function getRankUserCapacity($slug)
    {
        try {
            if (!$dataRating = $this->major->getRankUserCapacity($slug)) return $this->responseApi(true, ['error' => 'Không tìm thấy chuyên ngành ' . $slug . '!']);
            return $this->responseApi(
                true,
                $dataRating
            );
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }
}