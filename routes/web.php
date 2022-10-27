<?php

use App\Events\PublicChannel;
use App\Http\Controllers\AuthController;
use App\Jobs\test;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/admin');
Route::group(['prefix' => 'auth', 'middleware' => "guest"], function () {
    Route::get('login', [AuthController::class, 'adminLogin'])->name('login');

    Route::get('google', [AuthController::class, 'redirectToGoogle'])->name('auth.redirect-google');
    Route::get('google/callback', [AuthController::class, 'adminGoogleCallback'])->name('google-auth.callback');
});
Route::any('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('download-file', function () {
    $fileName = request('page') ?? '' . request('url') ?? '';
    $headers = [
        'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
    ];
    if (!\Storage::disk('s3')->has($fileName)) return 'Không tồn tại file trong hệ thống ';
    return \Response::make(\Storage::disk('s3')->get($fileName), 200, $headers);
})->name('dowload.file');


Route::get('test', function () {
    // dispatch(new test())->onQueue('shedule');
    // \Illuminate\Support\Facades\Cookie::queue('test-cookie-laravel', 'value test', 2);
    // broadcast(new PublicChannel("This is message"));
});