<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\contestSkill>
 */
class contestSkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'contest_id' => Contest::where('type', 1)->random()->id,
            'skill_id' => Skill::all()->random()->id,
        ];
    }
}
