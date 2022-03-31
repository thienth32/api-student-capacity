<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('teams')->group(function () {


    Route::get('', [TeamController::class, 'ListTeam'])->name('admin.teams'); // Api list Danh sách teams theo cuộc thi. phía view
    Route::delete('{id}', [TeamController::class, 'deleteTeam'])->name('admin.delete.teams'); // Api xóa teams phía view
    Route::post('api-add-team', [TeamController::class, 'Api_addTeam']);
    Route::post('api-teams',[TeamController::class, 'ApiContestteams'])->name('admin.contest.team');
});
