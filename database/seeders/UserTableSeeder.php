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
                'name' => "vandtph22521",
                'email' => 'vandtph22521@fpt.edu.vn'
            ],
        ];
        foreach ($users as $u) {
            $model = new User();
            $model->fill($u);
            $model->save();
            $model->assignRole('super admin');
        }
    }
}
