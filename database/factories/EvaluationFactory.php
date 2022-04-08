<?php

namespace Database\Factories;

use App\Models\Judge;
use App\Models\Judges_round;
use App\Models\TakeExams;
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
            'exams_team_id' => TakeExams::all()->random()->id,
            'judge_round_id' => Judges_round::all()->random()->id,
        ];
    }
}
