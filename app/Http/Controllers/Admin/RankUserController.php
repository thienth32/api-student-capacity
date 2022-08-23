<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Modules\MMajor\MMajorInterface;
use App\Services\Traits\TResponse;
use Illuminate\Support\Facades\Log;

class RankUserController extends Controller
{
    public function __construct(private MMajorInterface $major)
    {
    }
    use TResponse;
    /**
     * @OA\Get(
     *     path="/api/public/rating-major/{slug}",
     *     description="Description api slider",
     *     tags={"Rank user" , "User" , "Major"},
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
    // Xep hang sinh vien theo chuyen nganh
    public function getRatingUser(MMajorInterface $majorModel, $slug)
    {
        try {
            if (!$dataRating = $majorModel->getRatingUserByMajorSlug($slug)) return $this->responseApi(false, 'Không tìm thấy chuyên ngành ' . $slug . '!');

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


    public function getRankUserCapacity($slug)
    {
        try {
            if (!$dataRating = $this->major->getRankUserCapacity($slug)) return $this->responseApi(false, 'Không tìm thấy chuyên ngành ' . $slug . '!');

            return $this->responseApi(
                true,
                $dataRating
            );
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }
}