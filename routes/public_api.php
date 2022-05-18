<?php

use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\ContestController as AdminContestController;
use App\Http\Controllers\Admin\EnterpriseController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\MajorController as AdminMajorController;
use App\Http\Controllers\Admin\ResultController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoundController;
use App\Http\Controllers\Admin\SendMailController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SponsorController as AdminSponsorController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('sponsors', [AdminSponsorController::class, 'list']);

Route::get('users', [AdminUserController::class, 'index']); // danh sách user

Route::get('company', [AdminCompanyController::class, 'listCompany']); // Doanh nghiệp


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

Route::prefix('sliders')->group(function () {
    Route::get('', [SliderController::class, 'apiIndex'])->name('slider.api.index');
});



Route::get('', [AdminMajorController::class, 'apiIndex'])->name('major.api.index');


Route::get('{slug}', [AdminMajorController::class, 'apiShow'])->name('major.api.show');

Route::get('{slug}', [AdminMajorController::class, 'apiShow'])->name('major.api.name');

Route::prefix('enterprise')->group(function () {
    Route::get('', [EnterpriseController::class, 'apiIndex'])->name('enterprise.api.index');
});
Route::prefix('exam')->group(function () {
    Route::post('store', [ExamController::class, 'store'])->name('exam.api.store');
    Route::get('download', [ExamController::class, 'download'])->name('exam.api.download');
});

Route::prefix('contest/round/{id_round}/result')->group(function () {
    Route::get('', [ResultController::class, 'indexApi']);
});