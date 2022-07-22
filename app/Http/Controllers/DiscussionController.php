<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Models\Classroom;
use App\Models\Discussion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    public function sendMessage(Request $request)
    {
        $data = Discussion::create([
            'classroom_id' => $request->classroom_id,
            'user_id' => $request->user_id,
            'message' => $request->message,
        ]);

        $room = Classroom::find($request->classroom_id);
        $user = User::find($request->user_id);
        if ($request->user_id==Auth::id()) {
            if(Auth::id()==$room->user_id){
                $data = '<p class="userText my-2"><span><sup class="mr-3 bg-success p-1 rounded"><small> Teacher</small></sup>'.$request->message.'</span></p>';
                $data1 = '<p class="botText my-2"><span> '.$request->message.'<sup class="ml-3 bg-success p-1 rounded"><small> Teacher</small></sup></span></p>';
            }else{
                $data = '<p class="userText my-2"><span><sup class="mr-3"><small>'.$user->username.'</small></sup>'.$request->message.'</span></p>';
                $data1 = '<p class="botText my-2"><span> '.$request->message.'<sup class="ml-3"><small>'.$user->username.'</small></sup></span></p>';
            }
        } else {
            if(Auth::id()==$room->user_id){
                $data1 = '<p class="userText my-2"><span><sup class="mr-3 bg-success p-1 rounded"><small> Teacher</small></sup>'.$request->message.'</span></p>';
                $data = '<p class="botText my-2"><span> '.$request->message.'<sup class="ml-3 bg-success p-1 rounded"><small> Teacher</small></sup></span></p>';
            }else{
                $data1 = '<p class="userText my-2"><span><sup class="mr-3"><small>'.$user->username.'</small></sup>'.$request->message.'</span></p>';
                $data = '<p class="botText my-2"><span> '.$request->message.'<sup class="ml-3"><small>'.$user->username.'</small></sup></span></p>';
            }
        }
        broadcast(new SendMessage($data1,$request->classroom_id))->toOthers();
        // event(new SendMessage($data1));
        return response($data);
    }
}
