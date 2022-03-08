<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login-token', [AuthController::class, 'postLoginToken'])->middleware('cors');
Route::post('fake-login', [AuthController::class, 'fake_login']);