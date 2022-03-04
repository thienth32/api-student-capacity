<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['role:super admin']], function () {
    Route::get('/users', [UserController::class, 'list']);

    Route::group(['prefix' => 'account'], function () {
        Route::post('add', [UserController::class, 'add_user']);
    });
});