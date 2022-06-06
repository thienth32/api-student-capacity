<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(MajorSeeder::class);
        // $this->call(ContestSeeder::class);
        // $this->call(EnterpriseSeeder::class);
        // $this->call(TypeExamSeeder::class);
        // $this->call(RoundSeeder::class);
        // $this->call(DonorSeeder::class);
        $this->call(UserTableSeeder::class);
        // $this->call(TeamSeeder::class);
        // $this->call(memberSeeder::class);
        // $this->call(judgeSeeder::class);
        // $this->call(resultSeeder::class);
        // \App\Models\User::factory(10)->create();
        // \App\Models\Sponsor::factory(10)->create();

    }
}
