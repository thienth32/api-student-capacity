<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([
            [
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), 'name' => 'Lập trình ECMAScript ', 'short_name' => 'WEB501', 'image_url' => '629cd613737ec-1654445587.png', 'description' => 'ECMAScript (hay ES) là một thương hiệu đặc tả ngôn ngữ kịch bản được tiêu chuẩn hóa bởi Ecma International thông qua ECMA-262 và ISO/IEC 16262. Nó được tạo ra để tiêu chuẩn hóa JavaScript, để thúc đẩy nhiều hiện thực độc lập.'
            ],
            [
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), 'name' => ' Lập trình TypeScript', 'short_name' => 'WEB502', 'image_url' => '629cd613737ec-1654445587.png', 'description' => 'TypeScript là một ngôn ngữ lập trình được phát triển và duy trì bởi Microsoft. Nó là một tập hợp siêu cú pháp nghiêm ngặt của JavaScript và thêm tính năng kiểu tĩnh tùy chọn vào ngôn ngữ. TypeScript được thiết kế để phát triển các ứng dụng lớn và chuyển đổi sang JavaScript.'
            ],
        ]);
    }
}
