<?php

use App\Events\SendMessage;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('addPoint', [ClassroomController::class, 'addPoint'])->name('addPoint');
Route::post('send', [DiscussionController::class, 'sendMessage'])->name('send');
Route::post('leave-quiz', [QuizController::class, 'leaveQuiz'])->name('quiz.leave');
