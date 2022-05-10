<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassStudent;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RaporController extends Controller
{
    public function index()
    {
        $room = ClassStudent::where('user_id',Auth::id())->first();
        $classrooms = Classroom::all()->where('room_id',$room->room_id)->first();
        $kelas = Room::find($room->room_id);
        $tugas = 0;
        foreach ($kelas->classroom as $classroom) {
            $a = $classroom->quizzes->where('category','TUGAS')->count();
            if($a > $tugas){
                $tugas = $a;
            }
        }
        $nilai = QuizResult::where('user_id',Auth::id())->get();
        return view('dashboard.rapor.index', compact('classrooms','room','nilai','kelas','tugas'));
    }
}
