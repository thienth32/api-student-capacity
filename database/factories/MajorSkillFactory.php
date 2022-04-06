<?php

namespace Database\Factories;

use App\Models\Major;
use App\Models\Skills;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MajorSkill>
 */
class MajorSkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'major_id' => Major::all()->random()->id,
            'skill_id' => Skills::all()->random()->id,
        ];
    }
}
