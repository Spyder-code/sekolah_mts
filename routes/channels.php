<?php

use App\Models\Classroom;
use App\Models\ClassStudent;
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

Broadcast::channel('room', function ($user) {
    return true;
});

Broadcast::channel('classroom.{id}', function ($user, $id) {
    if($user->role=='guru'){
        $classroom = Classroom::where('id', $id)->where('user_id', $user->id)->first();
        if($classroom){
            return true;
        }
    }else if($user->role=='siswa'){
        $classroom = Classroom::where('id', $id)->first();
        if($classroom){
            $classstudent = ClassStudent::where('room_id', $classroom->room_id)->where('user_id', $user->id)->first();
            if($classstudent){
                return true;
            }
        }
    }
});
