<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        // foreach($users as $u){
        //     if($u->id == 1){
        //         $u->assignRole('super admin');
        //     }else if($u->id <= 5){
        //         $u->assignRole('admin');
        //     }else{
        //         $u->assignRole('student');
        //     }
        // }
        foreach ($users as $u) {
            if ($u->id == 27) {
                $u->assignRole('super admin');
            }
        }
    }
}
