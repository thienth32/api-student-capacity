<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoundController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('rounds')->group(function () {
    Route::get('', [RoundController::class, 'index'])->name('web.round.list');
    Route::get('{id}/edit', [RoundController::class, 'edit'])->name('web.round.edit');
    Route::put('{id}', [RoundController::class, 'update'])->name('web.round.update');
    Route::delete('{id}', [RoundController::class, 'destroy'])->name('web.round.destroy');
});