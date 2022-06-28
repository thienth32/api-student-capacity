<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [

            [
                'name' => "Quan hệ doanh nghiệp",
                'email' => 'Qhdn.poly@fpt.edu.vn'
            ],
            [
                'name' => "Linhntt136",
                'email' => 'Linhntt136@fpt.edu.vn'
            ],
            [
                'name' => "Huongdtt43",
                'email' => 'Huongdtt43@fpt.edu.vn'
            ],
            [
                'name' => "Quynk4",
                'email' => 'Quynk4@fpt.edu.vn'
            ],

        ];
        foreach ($users as $u) {
            $model = new User();
            $model->fill($u);
            $model->save();
        }
    }
}
