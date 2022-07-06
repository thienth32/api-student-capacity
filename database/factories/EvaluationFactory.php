<?php

namespace Database\Factories;

use App\Models\Judge;
use App\Models\JudgeRound;
use App\Models\TakeExam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ponit' => mt_rand(1, 10),
            'exams_team_id' => TakeExam::all()->random()->id,
            'judge_round_id' => JudgeRound::all()->random()->id,
        ];
    }
}