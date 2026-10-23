<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FaqCategory::create([
            'name' => 'Thực tập',
            'parent_id' => null
        ]);
        FaqCategory::create([
            'name' => 'Việc làm',
            'parent_id' => null
        ]);
        FaqCategory::create([
            'name' => 'Sự kiện',
            'parent_id' => null
        ]);
    }
}
