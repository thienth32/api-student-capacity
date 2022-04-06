<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoundController;
use App\Http\Controllers\Admin\ContestController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnterpriseController;
use App\Http\Controllers\Admin\JudgesController;
use App\Http\Controllers\Admin\MajorController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard/api-cuoc-thi', [DashboardController::class, 'chartCompetity'])->name('dashboard.chart-competity');

Route::prefix('rounds')->group(function () {
    Route::get('form-add', [RoundController::class, 'create'])->name('admin.round.create');
    Route::post('form-add-save', [RoundController::class, 'store'])->name('admin.round.store');
    Route::get('', [RoundController::class, 'index'])->name('admin.round.list');
    Route::get('{id}/edit', [RoundController::class, 'edit'])->name('admin.round.edit');
    Route::put('{id}', [RoundController::class, 'update'])->name('admin.round.update');
    Route::delete('{id}', [RoundController::class, 'destroy'])->name('admin.round.destroy');

    Route::get('{id}/detail', [RoundController::class, 'adminShow'])->name('admin.round.detail');
});


Route::prefix('teams')->group(function () {
    //list
    Route::get('', [TeamController::class, 'ListTeam'])->name('admin.teams'); // Api list Danh sách teams theo cuộc thi. phía view
    Route::get('api-teams', [TeamController::class, 'ApiContestteams'])->name('admin.contest.team');
    // end lisst
    Route::delete('{id}', [TeamController::class, 'deleteTeam'])->name('admin.delete.teams'); // Api xóa teams phía view
    Route::get('form-add', [TeamController::class, 'create'])->name('admin.teams.create');
    Route::post('form-add-save', [TeamController::class, 'store'])->name('admin.teams.store');
    Route::get('form-edit/{id}', [TeamController::class, 'edit'])->name('admin.teams.edit');
    Route::put('form-edit-save/{id}', [TeamController::class, 'update'])->name('admin.teams.update');
});
Route::prefix('users')->group(function () {
    Route::post('team-user-search', [UserController::class, 'TeamUserSearch'])->name('admin.user.TeamUserSearch');
});


Route::prefix('contests')->group(function () {
    Route::get('{id}/edit', [ContestController::class, 'edit'])->name('admin.contest.edit');
    Route::put('{id}', [ContestController::class, 'update'])->name('admin.contest.update');

    Route::get('', [ContestController::class, 'index'])->name('admin.contest.list');
    Route::get('form-add', [ContestController::class, 'create'])->name('admin.contest.create');
    Route::post('form-add-save', [ContestController::class, 'store'])->name('admin.contest.store');
    Route::post('un-status/{id}', [ContestController::class, 'un_status'])->name('admin.contest.un.status');
    Route::post('re-status/{id}', [ContestController::class, 're_status'])->name('admin.contest.re.status');
    Route::delete('{id}', [ContestController::class, 'destroy'])->name('admin.contest.destroy');

    Route::prefix('{id}/detail')->group(function () {
        Route::get('', [ContestController::class, 'show'])->name('admin.contest.show');
        Route::get('rounds', [RoundController::class, 'contestDetailRound'])->name('admin.contest.detail.round');
        Route::get('teams', [ContestController::class, 'contestDetailTeam'])->name('admin.contest.detail.team');
        Route::post('teams-add', [ContestController::class, 'contestDetailTeamAdd'])->name('admin.contest.detail.team.add');
    });
});
Route::prefix('enterprise')->group(function () {
    Route::get('{id}/edit', [EnterpriseController::class, 'edit'])->name('admin.enterprise.edit');
    Route::put('{id}', [EnterpriseController::class, 'update'])->name('admin.enterprise.update');
    Route::get('', [EnterpriseController::class, 'index'])->name('admin.enterprise.list');
    Route::get('form-add', [EnterpriseController::class, 'create'])->name('admin.enterprise.create');
    Route::post('form-add-save', [EnterpriseController::class, 'store'])->name('admin.enterprise.store');
    Route::delete('{id}', [EnterpriseController::class, 'destroy'])->name('admin.enterprise.destroy');
});

Route::prefix('majors')->group(function () {
    Route::get('{slug}/edit', [MajorController::class, 'edit'])->name('admin.major.edit');
    Route::put('{slug}', [MajorController::class, 'update'])->name('admin.major.update');

    Route::get('', [MajorController::class, 'index'])->name('admin.major.list');
    Route::get('create', [MajorController::class, 'create'])->name('admin.major.create');
    Route::post('store', [MajorController::class, 'store'])->name('admin.major.store');

    Route::delete('{slug}', [MajorController::class, 'destroy'])->name('admin.major.destroy');
});

Route::prefix('judges')->group(function () {
    Route::get('{contest_id}/contest', [JudgesController::class, 'getJudgesContest'])->name('admin.judges.contest');

    Route::post('{contest_id}/attach', [JudgesController::class, 'attachJudges'])->name('admin.judges.attach');
    Route::post('{contest_id}/sync', [JudgesController::class, 'syncJudges'])->name('admin.judges.sync');
    Route::delete('{contest_id}/detach', [JudgesController::class, 'detachJudges'])->name('admin.judges.detach');
});