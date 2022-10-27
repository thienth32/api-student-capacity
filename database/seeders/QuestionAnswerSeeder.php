<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuestionAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = Skill::all();
        $province = [
            'An Giang',
            'Bà rịa – Vũng tàu',
            'Bắc Giang',
            'Bắc Kạn',
            'Bạc Liêu',
            'Bắc Ninh',
            'Bến Tre',
            'Bình Định',
            'Bình Dương',
            'Bình Phước',
            'Bình Thuận',
            'Cà Mau',
            'Cần Thơ',
            'Cao Bằng',
            'Đà Nẵng',
            'Đắk Lắk',
            'Đắk Nông',
            'Điện Biên',
            'Đồng Nai',
            'Đồng Tháp',
            'Gia Lai',
            'Hà Giang',
            'Hà Nam',
            'Hà Nội',
            'Hà Tĩnh',
            'Hải Dương',
            'Hải Phòng',
            'Hậu Giang',
            'Hòa Bình',
            'Hưng Yên',
            'Khánh Hòa',
            'Kiên Giang',
            'Kon Tum',
            'Lai Châu',
            'Lâm Đồng',
            'Lạng Sơn',
            'Lào Cai',
            'Long An',
            'Nam Định',
            'Nghệ An',
            'Ninh Bình',
            'Ninh Thuận',
            'Phú Thọ',
            'Phú Yên',
            'Quảng Bình',
            'Quảng Nam',
            'Quảng Ngãi',
            'Quảng Ninh',
            'Quảng Trị',
            'Sóc Trăng',
            'Sơn La',
            'Tây Ninh',
            'Thái Bình',
            'Thái Nguyên',
            'Thanh Hóa',
            'Thừa Thiên Huế',
            'Tiền Giang',
            'Thành phố Hồ Chí Minh',
            'Trà Vinh',
            'Tuyên Quang',
            'Vĩnh Long',
            'Vĩnh Phúc',
            'Yên Bái',
        ];
        $java =  [
            'Java List',
            'Java Iterator',
            'Java ListIterator',
            'Java ArrayList',
            'Java CopyOnWriteArrayList',
            'Java LinkedList',
            'Java Set',
            'Java SortedSet',
            'Java NavigableSet',
            'Java TreeSet',
            'Java CopyOnWriteArraySet',
            'Java Queue',
            'Java Deque',
            'Java PriorityQueue',
            'Java BlockingQueue',
            'Java ArrayBlockingQueue',
            'Java PriorityBlockingQueue',
            'Java TransferQueue',
            'Java Map',
            'Java SortedMap',
            'Java NavigableMap',
            'Java HashMap',
            'Java TreeMap',
            'Java IdentityHashMap',
            'Java WeakHashMap',
            'Java Collections Framework',
        ];
        $sentences = [
            ['Description', 'Constructor', 'Static', 'properties', 'Static', 'methods'],
            ['B - first', 'B - second', 'B - third'],
            ["Saab", "Volvo", "BMW"],
            ['Other', 'examples', 'Notes', 'Specifications', 'Browser', 'compatibility', 'See', 'also',],
            ["Banana", "Orange", "Apple", "Mango"],
            ['Instance', 'properties', 'Instance', 'methods', 'Examples'],
            ['Apple', 'Banana', 'Strawberry', 'Mango', 'Cherry'],
            ['C - first', 'C - second', 'C - third'],

        ];
        try {
            for ($i = 0; $i < 20; $i++) {
                $selected = array();
                foreach ($sentences as $sentence) {
                    $selected[] = $sentence[rand(0, count($sentence) - 1)];
                }
                $paragraph = implode(' ', $selected) . Str::random(5);
                $question = Question::create([
                    'content' => 'Câu hỏi ' . Str::random(5) . ' : ' . $paragraph . ' ' . $province[array_rand($province)] . ' ' . $java[array_rand($java)],
                    'type' =>  0,
                    'status' => 1,
                    'rank' => rand(0, 2),
                ]);
                $question->skills()->syncWithoutDetaching(
                    $skills->random(rand(1, 4))->pluck('id')->toArray()
                );
                $answerArr = [];
                $is_correct = rand(0, 3);
                for ($i = 0; $i < 4; $i++) {
                    array_push($answerArr, [
                        'content' => $sentences[3][array_rand($sentences[3])] . '' . $sentences[5][array_rand($sentences[5])] . ' ' . Str::random(5) . ' ' . $java[array_rand($java)] . '' . ($i == $is_correct ? 'true' : ''),
                        'question_id' => $question->id,
                        'is_correct' => ($i == $is_correct ? 1 : 0)
                    ]);
                }
                Answer::insert($answerArr);
            }
        } catch (\Throwable $th) {
        }
    }
}