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
     * @throws \Exception
     */
    public function definition()
    {
        // gio phut gaiy
        $time_created_at_updated_at = Carbon::create(2021, random_int(1, 5), random_int(1, 4), 0, 0, 0);

        $date = Carbon::create(2022, random_int(3, 5), random_int(1, 4), 0, 0, 0);

        $time_register = Carbon::create(2021, random_int(10, 12), random_int(1, 30), random_int(1, 24), random_int(1, 60), random_int(1, 60));


        return [
            'name' => 'Cuộc thi oo' . $this->faker->name,
            'img' => '629ec972b4ef3-1654573426.jpg',
            'start_register_time' => $time_register->format('Y-m-d H:i:s'),
            'end_register_time' => $time_register->addMonth(random_int(1, 2))->addWeeks(random_int(1, 3))->format('Y-m-d H:i:s'),
            'date_start' => $date->format('Y-m-d H:i:s'),
            'register_deadline' => $date->addWeeks(random_int(6, 9))->format('Y-m-d H:i:s'),
            'max_user' => 10,
            'major_id' => Major::all()->random()->id,
            'status' => true,
            'description' => $this->faker->sentence(15),
            'created_at' => $time_created_at_updated_at->format('Y-m-d H:i:s'),
            'updated_at' => $time_created_at_updated_at->addWeeks(random_int(1, 12))->format('Y-m-d H:i:s'),
            'type' => 0,
            'reward_rank_point' => '{"top1": "10", "top2": "9", "top3": "8", "leave": "5"}',
            'post_new' => $this->faker->sentence(20)
        ];
    }
}
