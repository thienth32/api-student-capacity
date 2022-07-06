<?php

use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\ContestController as AdminContestController;
use App\Http\Controllers\Admin\EnterpriseController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\MajorController as AdminMajorController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\RankUserController;
use App\Http\Controllers\Admin\RecruitmentController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\RoundController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SponsorController as AdminSponsorController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
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

Route::get('sponsors', [AdminSponsorController::class, 'list']);

Route::get('users', [AdminUserController::class, 'index']); // danh sách user

Route::get('company', [AdminCompanyController::class, 'listCompany']); // Doanh nghiệp

Route::prefix('contests')->group(function () {
    Route::get('', [AdminContestController::class, 'apiIndex'])->name('contest.api.index');
    Route::get('{id}', [AdminContestController::class, 'apiShow'])->name('contest.api.show');
});
Route::prefix('capacity')->group(function () {
    Route::get('', [AdminContestController::class, 'apiIndexCapacity'])->name('capacity.api.index');
    Route::get('{id}', [AdminContestController::class, 'apiShowCapacity'])->name('capacity.api.show');
    Route::get('{id}/related', [AdminContestController::class, 'apiCapacityRelated'])->name('capacity.api.related');
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

// Route::get('', [AdminMajorController::class, 'apiIndex'])->name('major.api.index');

// Route::get('{slug}', [AdminMajorController::class, 'apiShow'])->name('major.api.show');

Route::prefix('enterprise')->group(function () {
    Route::get('', [EnterpriseController::class, 'apiIndex'])->name('enterprise.api.index');
    Route::get('{id}', [EnterpriseController::class, 'apiDetail']);
});
Route::prefix('exam')->group(function () {
    Route::post('store', [ExamController::class, 'store'])->name('exam.api.store');
    Route::get('download', [ExamController::class, 'download'])->name('exam.api.download');
    Route::get('get-by-round/{id}', [ExamController::class, 'get_by_round'])->name('exam.api.get.round');
    Route::get('get-question-by-exam/{id}', [ExamController::class, 'showQuestionAnswerExams'])->name('exam.api.get.questions.exam');
});
Route::prefix('questions')->group(function () {
    Route::get('', [QuestionController::class, 'indexApi'])->name('questions.api.list');
    Route::post('save-question', [QuestionController::class, 'save_questions'])->name('questions.api.save.question');
    Route::post('dettach-question', [QuestionController::class, 'remove_question_by_exams'])->name('questions.api.dettach.question');
});

Route::prefix('contest/round/{id_round}/result')->group(function () {
    Route::get('', [ResultController::class, 'indexApi']);
});

Route::prefix('recruitments')->group(function () {
    Route::get('', [RecruitmentController::class, 'apiShow']);
    Route::get('{id}', [RecruitmentController::class, 'apiDetail']);
});


Route::get('rating-major/{slug}', [RankUserController::class, 'getRatingUser']);

Route::post('upload-file', function () {
    return "https://htmlcolorcodes.com/assets/images/html-color-codes-color-palette-generators.jpg";
});
