<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Round;
use App\Models\Result;
use App\Models\Contest;
use App\Models\TakeExam;
use App\Models\RoundTeam;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TakeExam_ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $qltFake = 10;
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $contests = Contest::where('type', 0)->whereDate('register_deadline', '<', $today)->has('rounds')->get()->pluck(['id']);
        $rounds = Round::where('contest_id', $contests->toArray())->get()->pluck(['id']);
        $roundTeams = RoundTeam::whereIn('round_id', $rounds)->has('exams')->doesntHave('takeExam')
            ->with(['exams'])->get()->makeHidden(['created_at', 'updated_at', 'deleted_at', 'status'])->random($qltFake)->toArray();
        $resultArr = [];
        $takeExam = [];
        foreach ($roundTeams as $key => $roundTeam) {
            $takeExam[] = [
                'exam_id' => $roundTeam['exams'][array_rand($roundTeam['exams'])]['id'],
                'round_team_id' => $roundTeam['id'],
                'mark_comment' => null,
                'final_point' => random_int(5, 10),
                'result_url' => null,
                'file_url' => 'https://www.facebook.com/nguyenvantrong2511/',
                'status' => 2,
                "created_at" => \Carbon\Carbon::now(), # new \Datetime()
                "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
            ];
            $resultArr[] = [
                'team_id' => $roundTeam['team_id'],
                'round_id' => $roundTeam['round_id'],
                'point' => random_int(3, 10),
                "created_at" => \Carbon\Carbon::now(), # new \Datetime()
                "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
            ];
        }
        TakeExam::insert($takeExam);
        Result::insert($resultArr);
    }
}
