<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\Enterprise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donor>
 */
class DonorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'contest_id' => Contest::all()->random()->id,
            'enterprise_id' => Enterprise::all()->random()->id,
        ];
    }
}
