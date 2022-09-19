<?php

namespace Database\Factories;

use App\Models\Result;
use App\Models\Round;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\result>
 */
class resultFactory extends Factory
{
    protected $model = Result::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'team_id' => Team::all()->random()->id,
            'round_id' => 1,
            'point' => mt_rand(1, 10),
        ];
    }
}
