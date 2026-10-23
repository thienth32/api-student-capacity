<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Judge;
use App\Models\Contest;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class judgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        // Judge::factory(10)->create();
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $user  = User::all();
        Contest::where('type', 0)->whereDate('register_deadline', '<', $today)
            ->get()
            ->each(function ($contest) use ($user) {
                $contest->judges()->syncWithoutDetaching(
                    $user->random(random_int(2, 5))->pluck('id')->toArray()
                );
            });
    }
}
