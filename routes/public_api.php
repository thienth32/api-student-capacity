<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\Majorcontroller;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('sponsors', [SponsorController::class, 'list']);

Route::get('contests', [ContestController::class, 'listContest']);

Route::get('majors', [Majorcontroller::class, 'listMajor']); // Chuyên Ngành

Route::get('users', [UserController::class, 'list']); // danh sách user

Route::get('company', [CompanyController::class, 'listCompany']); // Doanh nghiệp

// TEAMS


Route::prefix('teams')->group(function () {
    Route::get('api', [TeamController::class, 'Api_ListTeam']); // Api list Danh sách teams theo cuộc thi. phía client
    Route::get('', [TeamController::class, 'ListTeam']); // Api list Danh sách teams theo cuộc thi. phía view
    Route::delete('{id}', [TeamController::class, 'deleteTeam']); // Api xóa teams phía view
    Route::post('api-add-team', [TeamController::class, 'Api_addTeam']);
});
