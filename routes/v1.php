<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoundController;
use App\Http\Controllers\Admin\ContestController;
use App\Http\Controllers\Admin\WishlistController;
use App\Http\Controllers\Admin\CodeManagerController;
use App\Http\Controllers\Admin\CapacityPlayController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Admin\TakeExamController as AdminTakeExamController;

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

//Route::group(['middleware' => ['role:super admin']], function () {
//    Route::group(['prefix' => 'account'], function () {
//        Route::post('/', [UserController::class, 'list']);
//        Route::post('add', [UserController::class, 'add_user']);
//        Route::delete('block/{id}', [UserController::class, 'block_user']);
//        Route::post('update-role-user/{id}', [UserController::class, 'updateRoleUser']);
//    });
//});

//Route::group(['prefix' => 'majors'], function () {
//    Route::post('/', [\App\Http\Controllers\Admin\Majorcontroller::class, 'store']);
//    Route::delete('/{id}', [\App\Http\Controllers\Admin\Majorcontroller::class, 'destroy']);
//    Route::put('/{id}', [\App\Http\Controllers\Admin\Majorcontroller::class, 'update']);
//    Route::get('/{id}/edit', [\App\Http\Controllers\Admin\Majorcontroller::class, 'edit']);
//});


Route::prefix('teams')->group(function () {
    // Route::get('{id}', [AdminTeamController::class, 'apiShow']);
    Route::post('add-team', [AdminTeamController::class, "apiAddTeam"]);
    Route::post('edit-team/{team_id}', [AdminTeamController::class, "apiEditTeam"]);
    Route::get('{id}', [AdminTeamController::class, 'apiShow'])->name('team.api.show');
    Route::get('check-user-team-contest/{id_contest}', [AdminTeamController::class, "checkUserTeamContest"]);
    Route::post('add-user-team-contest/{id_contest}/{id_team}', [AdminTeamController::class, "addUserTeamContest"]);
    Route::post('user-team-search/{id_contest}', [AdminTeamController::class, "userTeamSearch"]);
    Route::post('delete-user-team-contest', [AdminTeamController::class, "deleteUserTeamContest"]);
});

Route::prefix('take-exam')->group(function () {
    Route::post('student', [AdminTakeExamController::class, 'takeExamStudent']);
    Route::post('student-submit', [AdminTakeExamController::class, 'takeExamStudentSubmit']);

    Route::post('check-student-capacity', [AdminTakeExamController::class, 'checkStudentCapacity']);
    Route::post('student-capacity', [AdminTakeExamController::class, 'takeExamStudentCapacity']);
    Route::post('student-capacity-submit', [AdminTakeExamController::class, 'takeExamStudentCapacitySubmit']);
    Route::post('student-capacity-history', [AdminTakeExamController::class, 'takeExamStudentCapacityHistory']);
});


Route::prefix('round')->group(function () {
    Route::get('{id_round}/team-me', [RoundController::class, 'userTeamRound']);
});


Route::prefix('users')->group(function () {
    Route::get('contest-joined-and-not-joined', [UserController::class, 'contestJoinedAndNotJoined']);
    Route::get('contest-joined', [UserController::class, 'contestJoined']);
    Route::post('edit', [UserController::class, 'updateDetailUser']);
});

Route::post('get-next-round-capacity', [RoundController::class, 'nextRoundCapacity']);

Route::get("auth-room-play/{room}", [CapacityPlayController::class, 'autTokenPlay']);
Route::get("connect-room/{room}", [CapacityPlayController::class, 'userContinueTest']);
Route::post("sumit-room/{code}", [CapacityPlayController::class, 'submitQuestionCapacityPlay']);
Route::post("next-sumit-room/{code}", [CapacityPlayController::class, 'nextQuestionApi']);


Route::prefix('challenge')->group(function () {
    // Route::get('', [CodeManagerController::class, 'getCodechallAll']);
    // Route::get('{id}', [CodeManagerController::class, 'apiShow']);
    // Route::get('rating/{id}/{type_id}', [CodeManagerController::class, 'rating']);
    Route::post('run-code/{id}', [CodeManagerController::class, 'runCodechall']);
    Route::post('submit-code/{id}', [CodeManagerController::class, 'runCodeSubmitChall']);
});

//127.0.0.1:8000/api/v1/challenge/rating/{id challenge }/{id ngôn ngữ } METHOD=POST AUTH=TRUE
// 127.0.0.1:8000/api/v1/challenge/run-code/{id challenge }  METHOD=POST AUTH=TRUE TEST-CASE=1
// 127.0.0.1:8000/api/v1/challenge/submit-code/{id challenge }  METHOD=POST AUTH=TRUE TEST-CASE=FULL

Route::prefix('wishlist')->group(function () {
    Route::post('add', [WishlistController::class, 'addWishlist']);
    Route::post('remove', [WishlistController::class, 'removeWishlist']);
    Route::get('user', [WishlistController::class, 'list']);
    Route::get('count', [WishlistController::class, 'countWishlist']);
});