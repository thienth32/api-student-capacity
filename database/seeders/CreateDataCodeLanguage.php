<?php

namespace Database\Seeders;

use App\Models\CodeLanguage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateDataCodeLanguage extends Seeder
{
    public function run()
    {
        // $data = [
        //     [
        //         'name' => "Php 8.2.0",
        //         "ex" => "php",
        //         "type" => "php"
        //     ],
        //     [
        //         'name' => "C gcc",
        //         "ex" => "c",
        //         "type" => "gcc"
        //     ],
        //     [
        //         'name' => "C++ gcc",
        //         "ex" => "cpp",
        //         "type" => "gcc"
        //     ],
        //     [
        //         'name' => "Javascript 18.4.0",
        //         "ex" => "js",
        //         "type" => "javascript"
        //     ],
        //     [
        //         'name' => "Python 3.10.5",
        //         "ex" => "py",
        //         "type" => "python"
        //     ],
        //     [
        //         'name' => "Java",
        //         "ex" => "java",
        //         "type" => "java"
        //     ]
        // ];
        // DB::table('code_language')->insert($data);
        // DB::table('sample_challenge')->insert([
        //     'challenge_id' => 1,
        //     'code' => 'lakinTest',
        //     'code_language_id' => 1
        // ]);
        // DB::table('test_case')->insert([
        //     'challenge_id' => 1,
        //     'status' => 1,
        //     'input' => '1,2,3,4',
        //     'output' => 'CATS'
        // ]);
        // DB::table('sample_challenge')->insert([
        //     'challenge_id' => 1,
        //     'code' => 'lakinTest',
        //     'code_language_id' => 4
        // ]);
        // DB::table('test_case')->insert([
        //     'challenge_id' => 1,
        //     'status' => 1,
        //     'input' => '1,2,3,4',
        //     'output' => 'CATS'
        // ]);
    }
}