<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Major;
use App\Models\Contest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contest>
 */
class ContestFactory extends Factory
{
    protected $model = Contest::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // gio phut gaiy
        $time_created_at_updated_at = Carbon::create(2021, rand(1, 5), rand(1, 4), 0, 0, 0);

        $date = Carbon::create(2022, rand(3, 5), rand(1, 4), 0, 0, 0);

        $time_register = Carbon::create(2021, rand(10, 12), rand(1, 30), rand(1, 24), rand(1, 60), rand(1, 60));


        return [
            'name' => 'Cuộc thi oo' . $this->faker->name,
            'img' => '629ec972b4ef3-1654573426.jpg',
            'start_register_time' => $time_register->format('Y-m-d H:i:s'),
            'end_register_time' => $time_register->addMonth(rand(1, 2))->addWeeks(rand(1, 3))->format('Y-m-d H:i:s'),
            'date_start' => $date->format('Y-m-d H:i:s'),
            'register_deadline' => $date->addWeeks(rand(6, 9))->format('Y-m-d H:i:s'),
            'max_user' => 10,
            'major_id' => Major::all()->random()->id,
            'status' => true,
            'description' => $this->faker->sentence(15),
            'created_at' => $time_created_at_updated_at->format('Y-m-d H:i:s'),
            'updated_at' => $time_created_at_updated_at->addWeeks(rand(1, 12))->format('Y-m-d H:i:s'),
            'type' => 0,
            'reward_rank_point' => '{"top1": "10", "top2": "9", "top3": "8", "leave": "5"}',
            'post_new' => $this->faker->sentence(20)
        ];
    }
}