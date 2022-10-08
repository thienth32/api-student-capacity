<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Round;
use App\Models\Contest;
use App\Models\Judge;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Round::factory(20)->create();

        $today = Carbon::now()->format('Y-m-d H:i:s');
        $contests = Contest::where('type', 0)->whereDate('register_deadline', '<', $today)->get()->pluck('id');
        $contests = json_decode($contests);
        // $judge = Judge::whereIn('contest_id', $contests)->get();
        $sentences = [
            ['Description', 'Constructor', 'Static', 'properties', 'Static', 'methods'],
            ["Saab", "Volvo", "BMW"],
            ['B - first', 'B - second', 'B - third'],
            ["Banana", "Orange", "Apple", "Mango"],
            ['C - first', 'C - second', 'C - third'],
            ['Instance', 'properties', 'Instance', 'methods', 'Examples'],
            ['Apple', 'Banana', 'Strawberry', 'Mango', 'Cherry'],
            ['Other', 'examples', 'Notes', 'Specifications', 'Browser', 'compatibility', 'See', 'also',]
        ];
        $texts = [
            'Con người chúng ta không thể nào quyết định nơi chúng ta sinh ra nhưng ta có quyền chọn cách ta sống cho dù hoàn cảnh có khó khăn thế nào thì ta vẫn có thể tạo ra được niềm vui hạnh phúc từ hoàn cảnh ấy.',
            'Hãy tử tế với những gã nghiện máy tính, biết đâu sau này bạn sẽ làm việc cho ai đó trong số họ – Bill Gates',
            'Tôi nghĩ hầu hết những lời khuyên tiết kiệm cho giới trẻ là sai lầm. Tôi chẳng bao giờ tiết kiệm xu nào cho đến khi 40 tuổi. Thay vào đó, tôi đầu tư cho chính mình, học hành, làm chủ các kỹ năng và chuẩn bị. Những người bỏ vài đô la vào ngân hàng mỗi tuần sẽ làm tốt hơn nhiều nếu bỏ nó vào chính họ – Henry Ford',
            'Rủi ro lớn nhất là chẳng đối mặt với rủi ro nào. Trong một thế giới đang thay đổi rất nhanh, chiến lược mà chắc chắn sẽ thất bại chính là tránh xa các rủi ro – Mark Zuckerberg',
            'Hãy cố biến mọi thảm họa thành cơ hội – John Rockefeller.',
            'Bạn nghèo vì bạn không có tham vọng. 35 tuổi mà còn nghèo thì đấy là tại bạn. – Jack Ma',
            'Trong cuộc sống, không tránh khỏi lúc bạn đưa ra quyết định sai lầm. Nhưng nếu bạn đổ lỗi cho người khác vì lỗi lầm của mình… thì bạn vẫn chưa chín chắn đâu.',
            'Đừng chỉ vì ai đó trông mạnh mẽ, không có nghĩa là tất cả mọi thứ đều ổn. Ngay cả những người mạnh mẽ nhất cũng cần một người bạn để dựa vào vai mà khóc. Hãy kết hôn với người mà bạn thích chuyện trò với người đó, vì khi bạn già đi, bạn sẽ phát hiện, thích chuyện trò là một ưu điểm lớn.',
            'Nếu bạn khao khát một thứ gì đó chưa bao giờ có thì bạn cần phải chấp nhận những việc mà bạn chưa bao giờ làm.',
            'Cuộc sống không phải là phim ảnh, không có nhiều đến thế… những lần không hẹn mà gặp.',
            'Bạn bè bạn sẽ không cần bạn phải giải thích gì cả, còn với kẻ thù, thì dù bạn có giải thích bao nhiêu họ cũng chẳng tin đâu. Hãy cứ làm những gì mà thâm tâm bạn biết là đúng.',
            'Đường đi khó không vì ngăn sông cách núi mà khó vì lòng người ngại núi e sông.',
            'Người thông minh là người có thể che dấu đi sự thông minh của mình.',
            'Sự vĩ đại gây ra lòng đố kỵ, lòng đố kỵ đem lại thù hằn, thù hằn thì sinh ra dối trá.',
            'Đời sẽ dịu dàng hơn biết mấy, khi con người biết đặt mình vào vị trí của nhau. ',
            'Người đàn ông tình nguyện vì bạn mà theo đuổi mọi thứ chưa hẳn đã thật lòng yêu bạn, bởi vì thứ mà anh ta theo đuổi được không hẳn thuộc về bạn.',
        ];
        $images = [
            '629ecad4682be-1654573780.jpg',
            '629ecb1f9c36a-1654573855.jpg',
            '629e31c484ef9-1654534596.jpg',
            '629e322834552-1654534696.jpg',
            '629e326de9f5d-1654534765.jpg',
            '629ec359466ce-1654571865.jpg',
            '629ec3be1f1fc-1654571966.jpg',
            '629ed36eeb7ec-1654575982.png',
            '629ed417db9a2-1654576151.png',
            '629ed977a0fc1-1654577527.jpg',
            '629ed9aa83da8-1654577578.jpg',
            '629eda7ca36e8-1654577788.jpeg',
            '62a8b54bb935f-1655223627.jpg',
            '62a9f2843f66e-1655304836.jpg',
            '62b58157f38e3-1656062295.jpg',
            '62c69aed3cb48-1657182957.jpg',
            '62d95cc76f70a-1658412231.jpg',
            '62d95cc76f70a-1658412231.jpg',
            '62efdd4774f94-1659886919.jpg',
            '62fc96563f81e-1660720726.png',
            '62fc98271b925-1660721191.jpg',
        ];
        foreach ($contests as $key =>    $contest) {
            $judge = Judge::where('contest_id', $contest)->get();
            $date = Carbon::create(2022, rand(9, 10), rand(1, 4), 0, 0, 0);
            $start = $date->format('Y-m-d H:i:s');
            $end = $date->addWeeks(rand(1, 4))->format('Y-m-d H:i:s');
            $selected = array();
            foreach ($sentences as $sentence) {
                $selected[] = $sentence[rand(0, count($sentence) - 1)];
            }
            $paragraph = implode(' ', $selected) . Str::random(10);
            $round =  Round::create([
                'name' => 'Vòng thi cuộc thi ' . $paragraph,
                'image' =>  $images[array_rand($images)],
                'start_time' =>  $start,
                'end_time' =>  $end,
                'description' => $texts[array_rand($texts)],
                'contest_id' =>  $contest,
                'type_exam_id' => 1,
            ]);
            $round->judges()->syncWithoutDetaching(
                $judge->random(rand(2, 3))->pluck('id')->toArray()
            );
        }
    }
}