<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Contest;
use App\Models\Question;
use Illuminate\Support\Str;
use App\Services\Traits\TResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Exam;
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
            if (!$dataRating = $this->major->getRankUserCapacity($slug)) return $this->responseApi(false, 'Không tìm thấy chuyên ngành ' . $slug . '!');
            return $this->responseApi(
                true,
                $dataRating
            );
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }


    public function test()
    {

        // $question = $this->questionModel::create([
        //     'content' => $request->content,
        //     'type' =>  $request->type,
        //     'status' =>  $request->status,
        //     'rank' =>  $request->rank,
        // ]);
        // $question->skills()->syncWithoutDetaching($request->skill);
        // foreach ($request->answers as  $value) {
        //     if ($value['content'] != null) {
        //         $this->answerModel::create([
        //             'content' => $value['content'],
        //             'question_id' => $question->id,
        //             'is_correct' => $value['is_correct'][0] ?? 0
        //         ]);
        //     }
        // }

        for ($i = 0; $i < 5; $i++) {
        }



        // $questions = Question::all();
        // dd($questions->toArray());
        // $contests = Contest::where('type', config('util.TYPE_TEST'))
        //     ->has('rounds')
        //     ->with(['rounds'])
        //     ->get()->map(function ($q) {
        //         return $q->rounds->map(function ($q) {
        //             return [
        //                 'id' => $q->id,
        //                 'name' => $q->name
        //             ];
        //         });
        //     });
        // $collectionContests = collect($contests->toArray());
        // $roundARR = $collectionContests->collapse()->all();
        // $roundARR = [
        //     // [
        //     //     "id" => 116,
        //     //     "name" => "Vòng thi Static BMW B - first Mango C - third Instance Mango SpecificationsD3k5Tw9bdy"
        //     // ],
        //     [
        //         "id" => 122,
        //         "name" => "Vòng thi Static Volvo B - first Mango C - third methods Apple examplesEnv8Mo2LJy"
        //     ]
        // ];
        // dd($roundARR);
        // $sentences = [
        //     // ['Description', 'Constructor', 'Static', 'properties', 'Static', 'methods'],
        //     // ['B - first', 'B - second', 'B - third'],
        //     ["Saab", "Volvo", "BMW"],
        //     ['Other', 'examples', 'Notes', 'Specifications', 'Browser', 'compatibility', 'See', 'also',],
        //     ["Banana", "Orange", "Apple", "Mango"],
        //     // ['Instance', 'properties', 'Instance', 'methods', 'Examples'],
        //     // ['Apple', 'Banana', 'Strawberry', 'Mango', 'Cherry'],
        //     // ['C - first', 'C - second', 'C - third'],
        // ];
        // $texts = [
        //     'Hãy tử tế với những gã nghiện máy tính, biết đâu sau này bạn sẽ làm việc cho ai đó trong số họ – Bill Gates',
        //     'Hãy cố biến mọi thảm họa thành cơ hội – John Rockefeller.',
        //     'Bạn nghèo vì bạn không có tham vọng. 35 tuổi mà còn nghèo thì đấy là tại bạn. – Jack Ma',
        //     'Nếu bạn khao khát một thứ gì đó chưa bao giờ có thì bạn cần phải chấp nhận những việc mà bạn chưa bao giờ làm.',
        //     'Cuộc sống không phải là phim ảnh, không có nhiều đến thế… những lần không hẹn mà gặp.',
        //     'Đường đi khó không vì ngăn sông cách núi mà khó vì lòng người ngại núi e sông.',
        //     'Người thông minh là người có thể che dấu đi sự thông minh của mình.',
        //     'Sự vĩ đại gây ra lòng đố kỵ, lòng đố kỵ đem lại thù hằn, thù hằn thì sinh ra dối trá.',
        //     'Đời sẽ dịu dàng hơn biết mấy, khi con người biết đặt mình vào vị trí của nhau. ',
        //     'Mở rộng vòng tay để thay đổi, nhưng đừng để tuột mất các giá trị của bạn',
        //     'Dành chút thời gian ở một mình mỗi ngày',
        //     'Khi nhận ra bạn vừa mắc lỗi, hãy ngay lập tức sửa chữa sai lầm',
        //     'Đừng để bất hòa nhỏ làm tổn thương mối quan hệ lớn',
        //     'Hãy học các nguyên tắc để biết phá vỡ nguyên tắc đúng cách',
        //     'Chia sẻ kiến thức. Đó là cách để bạn luôn sống mãi.',
        //     'Bầu không khí yêu thương trong gia đình chính là nền tảng cho cuộc sống của bạn',
        //     'Tình yêu, tình bạn, không phải là cả đời không cãi nhau, mà là cãi nhau rồi vẫn có thể bên nhau cả đời.',
        //     '“Không có hoàn cảnh nào tuyệt vọng, chỉ có người tuyệt vọng vì hoàn cảnh.” -Khuyết danh',
        //     'Người quan tâm đến tôi, tôi sẽ quan tâm lại gấp bội!',
        //     'Người không quan tâm đến tôi, bạn dựa vào cái gì mà bảo tôi phải tiếp tục?',
        //     'Hãy học các nguyên tắc để biết phá vỡ nguyên tắc đúng cách.',
        //     'Trong cuộc chiến vì tự do, chân lý là vũ khí duy nhất mà chúng ta sở hữu.',
        //     'Từ bi và độ lượng không phải là dấu hiệu của yếu đuối, mà thực ra là biểu hiện của sức mạnh.'
        // ];
        // DB::beginTransaction();
        // try {
        //     foreach ($roundARR as $key => $round) {
        //         foreach ($sentences as $sentence) {
        //             $selected[] = $sentence[rand(0, count($sentence) - 1)];
        //         }
        //         $paragraph = implode(' ', $selected) . Str::random(5);
        //         $exam = Exam::create([
        //             'name' => 'Đề thi : ' . $paragraph . ' ' . $round['name'],
        //             'description' => 'Triết lý sống: ' .  $texts[array_rand($texts)],
        //             'round_id' =>  $round['id'],
        //             'type_exam_id' => 2,
        //             'status' => 1,
        //             'type' => 1,
        //             'ponit' => 50,
        //             'max_ponit' => 100,
        //             'time' => 15,
        //             'time_type' => 0,
        //             'external_url' => 'null'
        //         ]);
        //         $exam->questions()->syncWithoutDetaching(
        //             $questions->random(rand(15, 20))->pluck('id')->toArray()
        //         );
        //     }
        //     DB::commit();
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     dd($th);
        // }
        // die;








        // $date = Carbon::create(2022, 10, 1, 0, 0, 0);
        // $start = $date->format('Y-m-d H:i:s');
        // for ($i = 0; $i < 5; $i++) {
        //     $end = $date->addWeeks(rand(1, 12))->format('Y-m-d H:i:s');
        //     $selected = array();
        //     foreach ($sentences as $sentence) {
        //         $selected[] = $sentence[rand(0, count($sentence) - 1)];
        //     }
        //     $paragraph = implode(' ', $selected) . Str::random(10);
        //     array_push($roundArr, [
        //         'name' => 'Vòng thi ' . $paragraph,
        //         'image' =>  $images[array_rand($images)],
        //         'start_time' =>  $start,
        //         'end_time' =>  $end,
        //         'description' => $texts[array_rand($texts)],
        //         // 'description' =>  $sentences[7][array_rand($sentences[7])] . ' ' . $texts . ' ' . Str::random(10),
        //         'contest_id' =>  $contests[array_rand($contests)],
        //         'type_exam_id' => 2,
        //     ]);
        // }

        // dd($roundArr);

        // foreach ($contests as $key => $contest) {
        //     if (count($contest->rounds) > 0) {
        //         foreach ($contest->rounds as $key => $round) {
        //             dump($round->toArray());
        //         }
        //     }
        // }
        // die;
        // dd($contests->toArray());

        // $questions = Question::all();
        // dd($questions->toArray());
        // $contests = Contest::where('type', config('util.TYPE_TEST'))
        //     ->with(['rounds' => function ($q) {
        //         return $q->with(['exams' => function ($q) {
        //             return $q->with(['questions']);
        //         }]);
        //     }])
        //     ->get();


        // foreach ($contests as $key => $contest) {
        //     if (count($contest->rounds) > 0) {
        //         foreach ($contest->rounds as $key => $round) {
        //             dump($round->toArray());
        //         }
        //     }
        // }
        // die;
        // dd($contest->toArray());
    }
}