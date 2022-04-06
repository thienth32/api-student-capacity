<?php

use App\Http\Controllers\Admin\ContestController as AdminContestController;
use App\Http\Controllers\Admin\MajorController as AdminMajorController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Majorcontroller;
use App\Http\Controllers\Admin\RoundController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\TeamController;

use App\Models\Team;


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

Route::get('majors', [Majorcontroller::class, 'listMajor']); // Chuyên Ngành

Route::get('users', [UserController::class, 'index']); // danh sách user

Route::get('company', [CompanyController::class, 'listCompany']); // Doanh nghiệp

// TEAMS


// Route::prefix('teams')->group(function () {
//     Route::post('api-add-team', [TeamController::class, 'Api_addTeam']);
// });


Route::prefix('contests')->group(function () {
    Route::get('', [AdminContestController::class, 'apiIndex'])->name('contest.api.index');
    Route::get('{id}', [AdminContestController::class, 'apiShow'])->name('contest.api.show');
});
Route::prefix('rounds')->group(function () {
    Route::get('', [RoundController::class, 'apiIndex'])->name('round.api.index');
    Route::get('{id}', [RoundController::class, 'show'])->name('round.api.show');
});
Route::prefix('majors')->group(function () {

    Route::get('', [AdminMajorController::class, 'apiIndex'])->name('major.api.index');


    Route::get('{slug}', [AdminMajorController::class, 'apiShow'])->name('major.api.show');
});
