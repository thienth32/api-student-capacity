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
                'name' => "Nguyễn Thị Linh",
                'email' => 'linhntph17474@fpt.edu.vn'
            ],
            [
                'name' => "Hà Thị Diệp",
                'email' => 'diephtbph13471@fpt.edu.vn'
            ],

        ];
        foreach ($users as $u) {
            $model = new User();
            $model->fill($u);
            $model->save();
        }
    }
}
