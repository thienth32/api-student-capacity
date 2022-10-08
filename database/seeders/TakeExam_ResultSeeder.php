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
     */
    public function run()
    {
        $qltFake = 10;
        $today = Carbon::now()->format('Y-m-d H:i:s');
        // $contests = Contest::where('type', 0)->whereDate('register_deadline', '<', $today)->has('rounds')->get()->pluck(['id']);
        $contests = Contest::find(49);
        $rounds = Round::where('contest_id', $contests->id)->get()->pluck(['id']);
        $roundTeams = RoundTeam::whereIn('round_id', $rounds)->has('exams')->doesntHave('takeExam')->with(['exams' => function ($q) {
            return $q->select(['id', 'round_id']);
        }])->get()->makeHidden(['created_at', 'updated_at', 'deleted_at', 'status'])->random($qltFake)->toArray();
        $resultArr = [];
        foreach ($roundTeams as $key => $roundTeam) {
            TakeExam::create([
                'exam_id' => $roundTeam['exams'][array_rand($roundTeam['exams'])]['id'],
                'round_team_id' => $roundTeam['id'],
                'mark_comment' => null,
                'final_point' => rand(5, 10),
                'result_url' => null,
                'file_url' => 'https://www.facebook.com/nguyenvantrong2511/',
                'status' => 2
            ]);
            array_push($resultArr, [
                'team_id' => $roundTeam['team_id'],
                'round_id' => $roundTeam['round_id'],
                'point' => rand(3, 10)
            ]);
        }
        Result::insert($resultArr);
    }
}