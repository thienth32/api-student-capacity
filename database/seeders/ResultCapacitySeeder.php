<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\User;
use App\Models\Round;
use App\Models\Contest;
use App\Models\ResultCapacity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResultCapacitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contests = Contest::where('type', config('util.TYPE_TEST'))->has('rounds')->pluck('id');
        $rounds = Round::whereIn('contest_id', $contests)->has('exams')->pluck('id')->toArray();
        $exams = Exam::whereIn('round_id', $rounds)->pluck('id')->toArray();
        $users = User::all()->pluck('id')->toArray();
        $resultCapacityArr = [];
        for ($i = 0; $i < 50; $i++) {
            array_push($resultCapacityArr, [
                'scores' => rand(20, 100),
                'status' => 1,
                'exam_id' =>  $exams[array_rand($exams)],
                'user_id' =>  $users[array_rand($users)],
                'type' => 1,
                'donot_answer' => rand(0, 5),
                'false_answer' => rand(1, 5),
                'true_answer' => rand(9, 15),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->addMinutes(rand(10, 15))->toDateTimeString()
            ]);
        }
        ResultCapacity::insert($resultCapacityArr);
    }
}