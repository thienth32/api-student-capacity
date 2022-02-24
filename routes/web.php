<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('products', function(){
    $products = [
        [
            "id" => 1,
            "name" => "poly"
        ],
        [
            "id" => 2,
            "name" => "Btec"
        ],
        [
            "id" => 3,
            "name" => "melburn"
        ],

    ];
    return response()->json($products);
})->middleware('cors');