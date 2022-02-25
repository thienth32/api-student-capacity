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
                'name' => "Trần Hữu Thiện",
                'email' => 'thienth@fpt.edu.vn'
            ],
            [
                'name' => "Nguyễn Đức Bình",
                'email' => 'binhndph15107@fpt.edu.vn'
            ],
            [
                'name' => "Trần Văn Quảng",
                'email' => 'quangtvph14034@fpt.edu.vn'
            ],
            [
                'name' => "Nguyễn Văn Trọng",
                'email' => 'trongnvph13949@fpt.edu.vn'
            ],
            [
                'name' => "Nguyễn Ngọc Uy",
                'email' => 'uynnph15055@fpt.edu.vn'
            ],
        ];
        foreach ($users as $u) {
            $model = new User();
            $model->fill($u);
            $model->save();
        }
        
    }
}
