<?php

use App\Models\Exam;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('room.{room}', [CapacityPlayController::class, 'channel']);
Broadcast::channel('room.{room}', function ($user, $room) {
    $exam = Exam::where('room_code', $room)->first();
    if ($exam->status == 2 && $exam->room_token) return false;
    return $user;
});