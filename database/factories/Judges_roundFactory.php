<?php

namespace Database\Factories;

use App\Models\Judge;
use App\Models\Round;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JudgeRound>
 */
class Judges_roundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'round_id' => Round::all()->random()->id,
            'judge_id' => Judge::all()->random()->id,
        ];
    }
}