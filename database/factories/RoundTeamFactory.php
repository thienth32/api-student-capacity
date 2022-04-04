<?php

namespace Database\Factories;

use App\Models\Round;
use App\Models\RoundTeam;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoundTeam>
 */
class RoundTeamFactory extends Factory
{
protected $model=RoundTeam::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'team_id' => Team::all()->random()->id,
            'round_id' => Round::all()->random()->id,
        ];
    }
}
