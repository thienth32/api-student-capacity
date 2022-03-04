<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('majors')->insert([
            ['name' => 'Thiết kế web', 'slug' => 'thiet-ke-web'],
            ['name' => 'Thiết kế đồ họa', 'slug' => 'thiet-ke-do-hoa']
        ]);
    }
}
