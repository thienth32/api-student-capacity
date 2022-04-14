<?php

use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Admin\UserController;
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

Route::get('get-user-by-token', [UserController::class, 'get_user_by_token']);

Route::group(['middleware' => ['role:super admin']], function () {

    Route::group(['prefix' => 'account'], function () {
        Route::post('/', [UserController::class, 'list']);
        Route::post('add', [UserController::class, 'add_user']);
        Route::delete('block/{id}', [UserController::class, 'block_user']);
        Route::post('update-role-user/{id}', [UserController::class, 'updateRoleUser']);
    });
});

Route::group(['prefix' => 'majors'], function () {
    Route::post('/', [\App\Http\Controllers\Admin\Majorcontroller::class, 'store']);
    Route::delete('/{id}', [\App\Http\Controllers\Admin\Majorcontroller::class, 'destroy']);
    Route::put('/{id}', [\App\Http\Controllers\Admin\Majorcontroller::class, 'update']);
    Route::get('/{id}/edit', [\App\Http\Controllers\Admin\Majorcontroller::class, 'edit']);
});


Route::prefix('teams')->group(function () {
    Route::post('{contest_id}/add-team', [AdminTeamController::class, "apiAddTeam"])->name('client.api.add.team');
    Route::put('edit-team/{team_id}', [AdminTeamController::class, "apiEditTeam"])->name('client.api.edit.team');
});