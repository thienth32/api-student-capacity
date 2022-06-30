<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $roles = [
        //     ['name' => 'super admin'],
        //     ['name' => 'admin'],
        //     ['name' => 'member'],
        //     ['name' => 'judge'],
        // ];
        $roles = [
            ['name' => 'teacher'],

        ];
        foreach ($roles as $r) {
            Role::create($r);
        }
    }
}
