<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\Contest;
use App\Models\RoundTeam;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Team::factory(30)->create();
        // $users = User::all();
        // $today = Carbon::now()->format('Y-m-d H:i:s');
        // $contests = Contest::where('type', 0)->whereDate('register_deadline', '<', $today)->has('rounds')->with(['rounds' => function ($q) {
        //     return $q->select(['contest_id', 'id']);
        // }])->get(['id']);
        // $contests = json_decode($contests);
        // $sentences = [
        //     ['Description', 'Constructor', 'Static', 'properties', 'Static', 'methods'],
        //     ["Saab", "Volvo", "BMW"],
        //     ['B - first', 'B - second', 'B - third'],
        //     ["Banana", "Orange", "Apple", "Mango"],
        //     ['C - first', 'C - second', 'C - third'],
        //     ['Instance', 'properties', 'Instance', 'methods', 'Examples'],
        //     ['Apple', 'Banana', 'Strawberry', 'Mango', 'Cherry'],
        //     ['Other', 'examples', 'Notes', 'Specifications', 'Browser', 'compatibility', 'See', 'also',]
        // ];
        // foreach ($contests as $key =>    $contest) {
        //     $selected = array();
        //     foreach ($sentences as $sentence) {
        //         $selected[] = $sentence[rand(0, count($sentence) - 1)];
        //     }
        //     $paragraph = implode(' ', $selected) . Str::random(10);
        //     $team =  Team::create([
        //         'name' => "Đội " . $paragraph,
        //         'contest_id' => $contest->id,
        //         'image' => null,
        //     ]);
        //     $team->members()->syncWithoutDetaching(
        //         $users->random(rand(2, 4))->pluck('id')->toArray()
        //     );
        //     if ($contest->rounds) {
        //         foreach ($contest->rounds as $key => $round) {
        //             RoundTeam::create([
        //                 'team_id' => $team->id,
        //                 'round_id' => $round->id,
        //                 'status' => 1
        //             ]);
        //         }
        //     }
        // }




        $users = User::all();
        $today = Carbon::now()->format('Y-m-d H:i:s');

        $contests = Contest::find(49)->load(['rounds' => function ($q) {
            return $q->select(['contest_id', 'id']);
        }]);
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

        for ($i = 0; $i < 10; $i++) {
            # code...
            $selected = array();
            foreach ($sentences as $sentence) {
                $selected[] = $sentence[rand(0, count($sentence) - 1)];
            }
            $paragraph = implode(' ', $selected) . Str::random(10);
            $team =  Team::create([
                'name' => "Đội " . $paragraph,
                'contest_id' => $contests->id,
                'image' => null,
            ]);
            $team->members()->syncWithoutDetaching(
                $users->random(rand(2, 4))->pluck('id')->toArray()
            );
            if ($contests->rounds) {
                foreach ($contests->rounds as $key => $round) {
                    RoundTeam::create([
                        'team_id' => $team->id,
                        'round_id' => $round->id,
                        'status' => 1
                    ]);
                }
            }
        }
    }
}