<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TeamController;

// use App\Http\Controllers\Admin\RoundController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route::prefix('teams')->group(function () {


//     Route::get('', [TeamController::class, 'ListTeam'])->name('admin.teams'); // Api list Danh sách teams theo cuộc thi. phía view
//     Route::delete('{id}', [TeamController::class, 'deleteTeam'])->name('admin.delete.teams'); // Api xóa teams phía view
//     // Route::post('api-add-team', [TeamController::class, 'Api_addTeam']);
//     Route::post('api-teams',[TeamController::class, 'ApiContestteams'])->name('admin.contest.team');
// });

Route::prefix('rounds')->group(function () {
    Route::get('form-add', [RoundController::class, 'create'])->name('admin.round.create');
    Route::post('form-add-save', [RoundController::class, 'store'])->name('admin.round.store');
});
Route::prefix('teams')->group(function () {
    //list
    Route::get('', [TeamController::class, 'ListTeam'])->name('admin.teams'); // Api list Danh sách teams theo cuộc thi. phía view
    Route::post('api-teams',[TeamController::class, 'ApiContestteams'])->name('admin.contest.team');
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
