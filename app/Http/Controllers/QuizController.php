<?php

namespace App\Http\Controllers;

use App\Events\QuizReport;
use App\Models\Classroom;
use App\Models\ClassStudent;
use App\Models\Discussion;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizReport as ModelsQuizReport;
use App\Models\QuizResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;

class QuizController extends Controller
{

    public function create(Classroom $classroom)
    {
        // $categories = $this->ApiGET('categories')['data'];

        return view('dashboard.classroom.quiz.create', compact('classroom'));
    }

    public function store(Request $request)
    {

        $validated = $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'category' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if($request->category!='TUGAS'){
            $cek = Quiz::where('classroom_id',$request->classroom_id)->where('category','TUGAS')->get();
            if(count($cek)==0){
                return redirect()->back()->with('error', 'Anda harus membuat Tugas terlebih dahulu');
            }
        }

        $validated['start_date'] = Carbon::parse($validated['start_date']);
        $validated['end_date'] = Carbon::parse($validated['end_date']);
        $quiz = Quiz::create($validated);

        for ($i=0; $i < count($request->question); $i++) {
            if ($request->question[$i]!=null) {
                $soal = [
                    'quiz_id' => $quiz->id,
                    'question' => $request->question[$i],
                    'answer_1' => $request->answer_1[$i],
                    'answer_2' => $request->answer_2[$i],
                    'answer_3' => $request->answer_3[$i],
                    'answer_4' => $request->answer_4[$i],
                    'answer_5' => $request->answer_5[$i],
                    'correct' => $request->correct[$i],
                ];
                Question::create($soal);
            }
        }

        foreach ($request->essay as $item ) {
            if ($item!=null) {
                $soal = [
                    'quiz_id' => $quiz->id,
                    'question' => $item,
                    'category' => 'essay',
                ];
                Question::create($soal);
            }
        }

        $classroom = Classroom::find($validated['classroom_id']);
        $student = ClassStudent::all()->where('room_id',$classroom->room_id);

        foreach ($student as $item ) {
            QuizResult::create([
                'user_id' => $item->user_id,
                'quiz_id' => $quiz->id,
                'score' => 0,
            ]);
        }


            Session::flash('success', 'Quiz Berhasil dibuat');

        return redirect()->route('classroom.show', $validated['classroom_id']);
    }

    public function store1(Request $request)
    {

        $validated = $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'category' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'questions' => 'required|array',
            'questions.*.content' => 'required|string',
            'questions.*.options.*.content' => 'required|string',
            'questions.*.options.*.answer' => 'sometimes|nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $validated['is_private'] = true;

        // $response = $this->ApiPOST('quiz', $validated);


            $validated['start_date'] = Carbon::parse($validated['start_date']);
            $validated['end_date'] = Carbon::parse($validated['end_date']);

            $quiz = Quiz::create($validated);

            $i = 1;
            foreach ($request->questions as $item ) {
                if ($item['content']!=null) {
                    $soal = [
                        'quiz_id' => $quiz->id,
                        'question' => $item['content']
                    ];
                    foreach ($item['options'] as $opt ) {
                        $soal['answer_'.$i] = $opt['content'];
                        if (!empty($opt['answer'])) {
                            $soal['correct'] = $i;
                        }
                        if (count($item['options'])==$i) {
                            $i=1;
                        }else{
                            $i++;
                        }
                    }
                    Question::create($soal);
                }
            }

            foreach ($request->essay as $item ) {
                if ($item!=null) {
                    $soal = [
                        'quiz_id' => $quiz->id,
                        'question' => $item,
                        'category' => 'essay',
                    ];
                    Question::create($soal);
                }
            }

            Session::flash('success', 'Quiz Berhasil dibuat');

        return redirect()->route('classroom.show', $validated['classroom_id']);
    }

    public function show(Quiz $quiz)
    {
        $data = QuizResult::all()->where('quiz_id', $quiz->id);
        $classroom = Classroom::find($quiz->classroom_id);
        $discussions = Discussion::all()->where('classroom_id',$classroom->id);
        return view('dashboard.classroom.quiz.history', compact('quiz', 'data', 'classroom', 'discussions'));
    }

    public function edit(Classroom $classroom, Quiz $quiz)
    {
        $choice = Question::all()->where('quiz_id',$quiz->id)->where('category','multiple choice');
        $essay = Question::all()->where('quiz_id',$quiz->id)->where('category','essay');
        return view('dashboard.classroom.quiz.edit', compact( 'quiz', 'classroom','choice','essay'));
    }

    public function update(Request $request)
    {

        $validated = $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'category' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $validated['start_date'] = Carbon::parse($validated['start_date']);
        $validated['end_date'] = Carbon::parse($validated['end_date']);

        Quiz::find($request->quiz_id)->update($validated);

        for ($i=0; $i < count($request->id_choice); $i++) {
            if ($request->question[$i]!=null) {
                $soal = [
                    'question' => $request->question[$i],
                    'answer_1' => $request->answer_1[$i],
                    'answer_2' => $request->answer_2[$i],
                    'answer_3' => $request->answer_3[$i],
                    'answer_4' => $request->answer_4[$i],
                    'answer_5' => $request->answer_5[$i],
                    'correct' => $request->correct[$i],
                ];
                Question::find($request->id_choice[$i])->update($soal);
            }
        }

        if(!empty($request->id_essay)){
            for ($i=0; $i < count($request->id_essay); $i++) {
                if ($request->essay[$i]!=null) {
                    $soal = [
                        'question' => $request->essay[$i],
                    ];
                    Question::find($request->id_essay[$i])->update($soal);
                }
            }
        }

        Session::flash('success', 'Quiz Berhasil diupdate');

        return redirect()->route('classroom.show', $request->classroom_id);
    }

    public function detail(Classroom $classroom, QuizResult $quiz_result)
    {
        $data = QuizAnswer::all()->where('quiz_result_id', $quiz_result->id);
        $correct = QuizAnswer::all()->where('quiz_result_id', $quiz_result->id)->where('is_correct',1)->count();
        $incorrect = QuizAnswer::all()->where('quiz_result_id', $quiz_result->id)->where('is_correct',0)->count();
        $essay = QuizAnswer::all()->where('quiz_result_id', $quiz_result->id)->where('is_correct',2);
        return view('dashboard.classroom.quiz.detail', compact('classroom','data','quiz_result','correct','incorrect','essay'));
    }

    public function kerjakan(Quiz $quiz)
    {
        // status 0->belum mengerjakan; 1->mengerjakan; 2->belum dinilai; 3->sudah dinilai
        $id_user = Auth::id();
        $quiz_result =  QuizResult::where('user_id',$id_user)->where('quiz_id',$quiz->id)->first();
        $now = date('Y-m-d H:i:s');
        $now = strtotime($now);
        // dd($now);
        //echo $now; // echos today!
        $start = date('Y-m-d H:i:s', strtotime($quiz->start_date));
        $end = date('Y-m-d H:i:s', strtotime($quiz->end_date));
        $contractDateBegin = strtotime($start);
        $contractDateEnd = strtotime($end);
        $classroom = Classroom::find($quiz->classroom_id);
        $discussions = Discussion::all()->where('classroom_id',$classroom->id);
        if (($now >= $contractDateBegin) && ($now <= $contractDateEnd)){
            if($quiz_result->status==3){
                Session::flash('success', 'Anda sudah mengerjakan!');
                return redirect()->route('classroom.show', $quiz->classroom_id);
            }else{
                ModelsQuizReport::create([
                    'quiz_id' => $quiz->id,
                    'user_id' => $id_user,
                    'report' => 'Mulai mengerjakan',
                ]);
                broadcast(new QuizReport($quiz->id, $id_user,'Mulai Mengerjakan'))->toOthers();
                $quiz_result->update(['status'=>1]);
                $data = Question::all()->where('quiz_id',$quiz->id)->where('category','multiple choice');
                $essay = Question::all()->where('quiz_id',$quiz->id)->where('category','essay');
                return view('dashboard.classroom.quiz.show', compact('data','essay','quiz','classroom','discussions'));
            }
        }else{
            Session::flash('danger', 'Waktu mengerjakan sudah habis!');
            return redirect()->route('classroom.show', $quiz->classroom_id);
        }

    }

    public function submitQuiz(Quiz $quiz, Request $request)
    {
        $quiz_result = QuizResult::where('user_id',Auth::id())->where('quiz_id', $quiz->id)->first();
        if(!empty($request->questions)){
            for ($i=0; $i < count($request->questions); $i++) {
                $question = Question::find($request->questions[$i]);
                if($request->answer[$i]==$question->correct){
                    $correct = 1;
                }else{
                    $correct = 0;
                }
                QuizAnswer::create([
                    'question_id' => $request->questions[$i],
                    'quiz_result_id' => $quiz_result->id,
                    'answer' => $request->answer[$i],
                    'is_correct' => $correct
                ]);
            }
        }

        if(!empty($request->essay)){
            for ($i=0; $i < count($request->essay); $i++) {
                QuizAnswer::create([
                    'question_id' => $request->essay[$i],
                    'quiz_result_id' => $quiz_result->id,
                    'answer' => $request->essay_answer[$i],
                    'is_correct' => 2
                ]);
            }
            QuizResult::find($quiz_result->id)->update(['status'=>2]);
        }else{
            $soal = QuizAnswer::all()->where('quiz_result_id',$quiz_result->id);
            $benar = QuizAnswer::all()->where('quiz_result_id',$quiz_result->id)->where('is_correct',1)->count();
            $count_soal = count($soal);
            $score = ($benar/$count_soal) * 100;
            QuizResult::find($quiz_result->id)->update(['score'=>$score,'status'=>3]);
        }

        $id_user = Auth::id();
        ModelsQuizReport::create([
            'quiz_id' => $quiz->id,
            'user_id' => $id_user,
            'report' => 'Selesai mengerjakan',
        ]);
        broadcast(new QuizReport($quiz->id, $id_user,'Selesai Mengerjakan'));
        Session::flash('success', 'Quiz Berhasil dikerjakan');

        return redirect()->route('classroom.show', $quiz->classroom_id);
    }

    public function updateNilai(QuizResult $quiz_result, Request $request)
    {
        QuizResult::find($quiz_result->id)->update(['score'=>$request->score,'status'=>3]);
        Session::flash('success', 'Berhasil menilai siswa!');

        return redirect()->route('quiz.detail',['classroom'=>$request->classroom_id,'quiz_result'=>$quiz_result->id]);
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        Session::flash('success', 'Quiz Berhasil dihapus');

        return redirect()->route('classroom.show', $quiz->classroom_id);
    }

    public function leaveQuiz()
    {
        $quiz_id = request('quiz_id');
        $user_id = request('user_id');
        $data = ModelsQuizReport::create([
            'quiz_id' => $quiz_id,
            'user_id' => $user_id,
            'report' => 'Meninggalkan Halaman Quiz',
        ]);
        broadcast(new QuizReport($quiz_id, $user_id,'Meninggalkan Halaman Quiz'));
        return response()->json($data);
    }

    public function quizReport()
    {
        $quiz_id = request('quiz_id');
        $data = ModelsQuizReport::where('quiz_id', $quiz_id)->select('id','user_id','created_at','report')->orderBy('created_at','desc');

        return DataTables::of($data)
            ->addColumn('user_id', function($data){
                return $data->user->name;
            })
            ->addColumn('created_at', function($data){
                return date('H:i:s', strtotime($data->created_at));
            })
            ->make(true);
    }
}
