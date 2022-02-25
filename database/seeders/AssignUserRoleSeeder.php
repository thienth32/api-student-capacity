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
        $users = User::orderBy('id')->take(5)->get();
        foreach($users as $u){
            if($u->email == 'thienth@fpt.edu.vn'){
                $u->assignRole('super admin');
            }else{
                $u->assignRole('admin');
            }
        }
    }
}
