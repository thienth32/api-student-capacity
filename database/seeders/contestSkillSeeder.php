<?php

namespace Database\Seeders;

use App\Models\Contest;
use App\Models\ContestSkill;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class contestSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            ContestSkill::create(
                [
                    'contest_id' => Contest::where('type', 1)->get()->random()->id,
                    'skill_id' => Skill::all()->unique()->random()->id
                ]
            );
        }
    }
}
