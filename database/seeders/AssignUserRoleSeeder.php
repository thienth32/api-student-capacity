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
        // foreach ($users as $u) {
        //     if ($u->id == 33) {
        //         $u->assignRole('super admin');
        //     } else if ($u->id == 36) {
        //         $u->assignRole('admin');
        //     } else if ($u->id == 37) {
        //         $u->assignRole('judge');
        //     } else if ($u->id == 38) {
        //         $u->assignRole('student');
        //     }
        // }
        foreach ($users as $u) {
            if ($u->id == 39) {
                $u->assignRole('super admin');
            }
        }
    }
}
