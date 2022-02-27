<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login-token', [AuthController::class, 'postLoginToken'])->middleware('cors');
?>