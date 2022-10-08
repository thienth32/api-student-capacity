<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Round;
use App\Models\Contest;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExamCapacitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $questions = Question::all();
        // capacity  
        // $contests = Contest::where('type', config('util.TYPE_TEST'))->has('rounds')->pluck('id');
        // $roundARR = Round::whereIn('contest_id', $contests)->get()->map(function ($q) {
        //     return [
        //         'id' => $q->id,
        //         'name' => $q->name
        //     ];
        // })->toArray();

        //cuoc thi
        $contests = Contest::where('type', 0)->whereDate('register_deadline', '<', $today)->has('rounds')->pluck('id');
        $roundARR = Round::whereIn('contest_id', $contests)->get(['id', 'name']);

        $sentences = [
            ["Saab", "Volvo", "BMW"],
            ['Other', 'examples', 'Notes', 'Specifications', 'Browser', 'compatibility', 'See', 'also',],
            ["Banana", "Orange", "Apple", "Mango"],
        ];
        $texts = [
            'Hãy tử tế với những gã nghiện máy tính, biết đâu sau này bạn sẽ làm việc cho ai đó trong số họ – Bill Gates',
            'Hãy cố biến mọi thảm họa thành cơ hội – John Rockefeller.',
            'Bạn nghèo vì bạn không có tham vọng. 35 tuổi mà còn nghèo thì đấy là tại bạn. – Jack Ma',
            'Nếu bạn khao khát một thứ gì đó chưa bao giờ có thì bạn cần phải chấp nhận những việc mà bạn chưa bao giờ làm.',
            'Cuộc sống không phải là phim ảnh, không có nhiều đến thế… những lần không hẹn mà gặp.',
            'Đường đi khó không vì ngăn sông cách núi mà khó vì lòng người ngại núi e sông.',
            'Người thông minh là người có thể che dấu đi sự thông minh của mình.',
            'Sự vĩ đại gây ra lòng đố kỵ, lòng đố kỵ đem lại thù hằn, thù hằn thì sinh ra dối trá.',
            'Đời sẽ dịu dàng hơn biết mấy, khi con người biết đặt mình vào vị trí của nhau. ',
            'Mở rộng vòng tay để thay đổi, nhưng đừng để tuột mất các giá trị của bạn',
            'Dành chút thời gian ở một mình mỗi ngày',
            'Khi nhận ra bạn vừa mắc lỗi, hãy ngay lập tức sửa chữa sai lầm',
            'Đừng để bất hòa nhỏ làm tổn thương mối quan hệ lớn',
            'Hãy học các nguyên tắc để biết phá vỡ nguyên tắc đúng cách',
            'Chia sẻ kiến thức. Đó là cách để bạn luôn sống mãi.',
            'Bầu không khí yêu thương trong gia đình chính là nền tảng cho cuộc sống của bạn',
            'Tình yêu, tình bạn, không phải là cả đời không cãi nhau, mà là cãi nhau rồi vẫn có thể bên nhau cả đời.',
            '“Không có hoàn cảnh nào tuyệt vọng, chỉ có người tuyệt vọng vì hoàn cảnh.” -Khuyết danh',
            'Người quan tâm đến tôi, tôi sẽ quan tâm lại gấp bội!',
            'Người không quan tâm đến tôi, bạn dựa vào cái gì mà bảo tôi phải tiếp tục?',
            'Hãy học các nguyên tắc để biết phá vỡ nguyên tắc đúng cách.',
            'Trong cuộc chiến vì tự do, chân lý là vũ khí duy nhất mà chúng ta sở hữu.',
            'Từ bi và độ lượng không phải là dấu hiệu của yếu đuối, mà thực ra là biểu hiện của sức mạnh.'
        ];

        // tesst nangw lucjw
        // for ($i = 0; $i < 10; $i++) {
        //     $round =   $roundARR[array_rand($roundARR)];
        //     $selected = array();
        //     foreach ($sentences as $sentence) {
        //         $selected[] = $sentence[rand(0, count($sentence) - 1)];
        //     }
        //     $paragraph = implode(' ', $selected) . Str::random(5);
        //     $exam = Exam::create([
        //         'name' => 'Đề thi : ' . $paragraph . ' ' . $round['name'],
        //         'description' => 'Triết lý sống: ' .  $texts[array_rand($texts)],
        //         'round_id' =>  $round['id'],
        //         'status' => 1,
        //         'type' => 1,
        //         'ponit' => 50,
        //         'max_ponit' => 100,
        //         'time' => 15,
        //         'time_type' => 0,
        //         'external_url' => 'null'
        //     ]);
        //     $exam->questions()->syncWithoutDetaching(
        //         $questions->random(rand(15, 20))->pluck('id')->toArray()
        //     );
        // }


        // cuoc thi
        foreach ($roundARR as $key => $round) {
            $selected = array();
            foreach ($sentences as $sentence) {
                $selected[] = $sentence[rand(0, count($sentence) - 1)];
            }
            $paragraph = implode(' ', $selected) . Str::random(5);
            Exam::create([
                'name' => 'Đề thi cuộc thi : ' . $paragraph . ' ' . $round->name,
                'description' => 'Triết lý sống: ' .  $texts[array_rand($texts)],
                'round_id' =>  $round->id,
                'status' => 1,
                'type' => 0,
                'ponit' => 50,
                'max_ponit' => 100,
                'time' => null,
                'time_type' => null,
                'external_url' => '633d4576042da-1664959862.zip'
            ]);
        }
    }
}