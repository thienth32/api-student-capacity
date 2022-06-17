<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enterprise;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EnterpriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('enterprises')->insert([

            [
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), 'name' => 'Công ty TNHH Cốc Cốc', 'logo' => '629d751c7bef7-1654486300.png', 'description' => 'Cốc Cốc đã trở thành một trong những Công Cụ Tìm Kiếm và Trình Duyệt Web lớn nhất Việt Nam. Ngoài ra khi so với các mạng quảng cáo online trong nước, Cốc Cốc là nền tảng quảng cáo lớn nhất với hơn 22 triệu người dùng.

                Nam phát triển các sản phẩm game cho các dòng điệnthoại và web.

                Tập thể lãnh đạo và nhân viên công ty Cổ phần Phần mềm Luvina luôn mở rộng cánh tay đón nhận những ứng viên có năng lực và kinh nghiệm trong ngành sản xuất phần mềm, và kể cả những bạn sinh viên mới ra trường chưa có kinh nghiệm. '
            ],
            [
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), 'name' => ' Công ty CP Thiết kế ADD Việt Nam', 'logo' => '629d751c7bef7-1654486300.png', 'description' => 'Công Ty CP Thiết Kế ADD Việt Nam là doanh nghiệp hoạt động trên lĩnh vực Thiết kế tryền thông đang có nhu cầu tuyển dụng nhân sự cho Phòng thiết kế truyền thông.
                '
            ],
        ]);
    }
}
