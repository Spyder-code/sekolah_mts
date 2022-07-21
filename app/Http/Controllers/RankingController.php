<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassStudent;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $room = ClassStudent::where('user_id', $user->id)->first();
        $classrooms = Classroom::where('room_id', $room->room_id)->pluck('id');
        $quizs = Quiz::whereIn('classroom_id', $classrooms)->pluck('id');
        $quizResult = QuizResult::all()->whereIn('quiz_id', $quizs)->groupBy('user_id');
        $data = array();
        foreach ($quizResult as $idx => $item) {
            $data[$idx]['name'] = $item->first()->student->name;
            $data[$idx]['score'] = $item->sum('score') / $item->count();
        }

        usort($data, function ($a, $b) {return $a['score'] < $b['score'];});
        return view('dashboard.ranking.index', compact('data','room'));
    }
}
