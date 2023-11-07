<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorForRecruitmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $majors = [
            [
                'name' => 'Công nghệ thông tin - Phát triển phần mềm',
                'slug' => 'cong-nghe-thong-tin-phat-trien-phan-mem',
                'for_recruitment' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kinh tế',
                'slug' => 'kinh-te',
                'for_recruitment' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'for_recruitment' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thiết kế đồ họa',
                'slug' => 'thiet-ke-do-hoa',
                'for_recruitment' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Điện, Cơ khí, tự động hóa',
                'slug' => 'dien-co-khi-tu-dong-hoa',
                'for_recruitment' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Du lịch - Nhà hàng - Khách sạn',
                'slug' => 'du-lich-nha-hang-khach-san',
                'for_recruitment' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'KBeauty',
                'slug' => 'kbeauty',
                'for_recruitment' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        \DB::table('majors')->insert($majors);
    }
}
