<?php

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

use App\Http\Controllers\Api\QuizHistoryController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\IntermezzoController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentTakeQuizController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::domain('ctrl'.env('APP_URL'))->group(function () {
// });
Route::get('/', function () {
   return redirect()->route('dashboard');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
   Route::get('/dashboard', DashboardController::class)->name('dashboard');

   Route::post('classroom/quiz/add',[QuizController::class,'store'])->name('quiz.store');
   Route::get('classroom/quiz/{quiz}', [QuizController::class,'show'])->name('quiz.show');
   Route::get('classroom/{classroom}/{quiz_result}', [QuizController::class,'detail'])->name('quiz.detail');
   // Route::post('classroom/quiz/{quiz}/submit', 'SubmitQuizController')->name('quiz.submit');
   Route::put('classroom/quiz/',[QuizController::class,'update'])->name('quiz.update');
   Route::get('classroom/{classroom}/quiz/create',[QuizController::class,'create'])->name('quiz.create');
   Route::get('classroom/{classroom}/quiz/{quiz}/edit',[QuizController::class,'edit'])->name('quiz.edit');
   Route::post('quiz/take/{quiz}', StudentTakeQuizController::class)->name('quiz.take');
   Route::put('classroom/quiz/kerjakan/{quiz}',[QuizController::class,'kerjakan'])->name('quiz.kerjakan');
   Route::put('classroom/quiz/update/nilai/{quiz_result}',[QuizController::class,'updateNilai'])->name('quiz.update.nilai');
   Route::post('classroom/quiz/submit/{quiz}',[QuizController::class,'submitQuiz'])->name('quiz.submit');

   Route::get('classroom', [ClassroomController::class,'index'])->name('classroom.index');
   Route::get('classroom/mapel/{classroom}/edit', [ClassroomController::class,'edit'])->name('classroom.edit');
   Route::get('classroom/create/room/{room}', [ClassroomController::class,'create'])->name('classroom.create');
   Route::resource('classroom', ClassroomController::class)->except(['index','create','edit']);
   Route::get('classrooms/students/{classroom}', [ClassroomController::class,'showStudents'])->name('classroom.students');
   Route::get('classroom/quiz_result/{classroom}', [ClassroomController::class,'showQuizResult'])->name('classroom.quiz.result');
   Route::delete('classroom/students/destroy/{classroomId}/{studentId}', [ClassroomController::class,'deleteStudent'])->name('classroom.student.destroy');
   Route::get('student/classroom', [StudentController::class,'ajaxSearch'])->name('students.ajax');
   Route::post('classroom/student/invite', [ClassroomController::class,'invite'])->name('students.invite');
   Route::post('classroom/course/add', [CourseController::class,'store'])->name('course.store');
   Route::delete('classroom/course/destroy/{course}', [CourseController::class,'destroy'])->name('course.destroy');
   Route::get('classroom/course/download/{id}', [FileController::class,'download'])->name('file.download');

   Route::get('enroll/classroom/{classroom}', [ClassroomController::class,'enrollView'])->name('enroll.view');
   Route::post('enroll/classroom/{classroom}', [ClassroomController::class,'enroll'])->name('enroll.classroom');
   Route::post('classroom/absensi', [ClassroomController::class,'absensi'])->name('absensi.classroom');
   Route::get('classroom/{classroom}/absensi/{date}', [ClassroomController::class,'absensiShow'])->name('absensi.date');
   Route::put('absensi/update/{attendance}', [ClassroomController::class,'absensiUpdate'])->name('absensi.update');


   Route::group(['middleware' => ['can:siswa']], function () {
       Route::get('history_quiz', QuizHistoryController::class)->name('quiz.history');
       Route::get('raport', [RaporController::class,'index'])->name('rapor.index');
   });

   Route::group(['middleware' => ['can:admin']], function () {
       Route::resource('users', UserController::class)->except(['create']);
       Route::resource('room', RoomController::class);
       Route::resource('post', PostController::class);
       Route::get('users/create/{name}', [UserController::class,'create'])->name('users.create');
       Route::get('user/siswa', [UserController::class,'siswa'])->name('user.siswa');
       Route::get('user/guru', [UserController::class,'guru'])->name('user.guru');
       Route::delete('drop-siswa', [RoomController::class,'dropSiswa'])->name('drop.siswa');
   });


   Route::group(['prefix' => 'user/profile'], function () {
       Route::get('/{username}', [ProfileController::class,'index'])->name('profile');
       Route::get('/{username}/change_password', [ProfileController::class,'editPassword'])->name('edit-password');
       Route::put('/edit/{user}', [ProfileController::class,'updateProfile'])->name('update.profile');
       Route::put('/change_password/{user}', [ProfileController::class,'updatePassword'])->name('update.password');
       Route::put('/{user}/update_foto', [ProfileController::class,'updateFoto'])->name('update.foto');
   });

//    Route::group(['namespace' => 'Resource','prefix' => 'resource'], function () {
//        Route::get('intermezzo', IntermezzoController::class)->name('resource.intermezzo');
//    });
});
Route::get('/home', [HomeController::class,'index'])->name('home');




// percobaan (bisa di hapus)
// Route::get('/', function () {
//    return redirect()->route('dashboard');
// });
// Auth::routes();

// Route::group(['middleware' => ['auth', 'can:admin']], function () {
//    Route::get('/dashboard', 'DashboardController')->name('dashboard');
//    Route::resource('users', 'UserController')->except(['create']);
//    Route::resource('room', 'RoomController');
//    Route::resource('post', 'PostController');
//    Route::get('users/create/{name}', 'UserController::class,create')->name('users.create');
//    Route::get('user/siswa', 'UserController::class,siswa')->name('user.siswa');
//    Route::get('user/guru', 'UserController::class,guru')->name('user.guru');
//    Route::delete('drop-siswa', 'RoomController::class,dropSiswa')->name('drop.siswa');

// });
// Route::group(['prefix' => 'user/profile'], function () {
//    Route::get('/{username}', 'ProfileController::class,index')->name('profile');
//    Route::get('/{username}/change_password', 'ProfileController::class,editPassword')->name('edit-password');
//    Route::put('/edit/{user}', 'ProfileController::class,updateProfile')->name('update.profile');
//    Route::put('/change_password/{user}', 'ProfileController::class,updatePassword')->name('update.password');
//    Route::put('/{user}/update_foto', 'ProfileController::class,updateFoto')->name('update.foto');
// });
// -- akhir percobaan (bisa di hapus)



Route::get('/',[ PageController::class,'index'])->name('user.index');
Route::get('/{postname}', [PageController::class,'post'])->name('user.post');
Route::get('/{postname}/{id}/{year?}/{title?}', [PageController::class,'postDetail'])->name('user.postdetail');


// Route::get('auth/google', 'Auth\GoogleController::class,redirectToProvider')->name('register.google');
// Route::get('auth/google/callback', 'Auth\GoogleController::class,handleProviderCallback');
