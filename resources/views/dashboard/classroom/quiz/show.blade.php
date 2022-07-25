@extends('layouts.app')
@section('title','Quiz - ' .  $quiz['name'] . ' - ')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-8">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>{{ $quiz['name'] }}</h6>
                    </div>
                    <form action="{{ route('quiz.submit', $quiz) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @csrf
                                @if ($data->count()>0)
                                <p>Multiple Choice</p>
                                <ol>
                                    @foreach($data as $question)
                                        <input type="hidden" name="questions[]" value="{{ $question['id'] }}">
                                        <p> <span class="py-1 px-2 bg-primary rounded-circle text-white mr-3">{{ $loop->iteration }}</span> {{ strip_tags($question['question']) }}</p>
                                        <div class="form-group row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="answer[{{ $loop->index }}]" id="answer_{{ $loop->iteration }}_1"  class="custom-control-input" value="1">
                                                    <label class="custom-control-label" for="answer_{{ $loop->iteration }}_1">{{ $question->answer_1 }}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="answer[{{ $loop->index }}]" id="answer_{{ $loop->iteration }}_3" class="custom-control-input" value="3">
                                                    <label class="custom-control-label" for="answer_{{ $loop->iteration }}_3">{{ $question->answer_3 }}</label>
                                                </div>
                                                @if ($question->answer_5!=null)
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="answer[{{ $loop->index }}]" id="answer_{{ $loop->iteration }}_5" class="custom-control-input" value="5">
                                                    <label class="custom-control-label" for="answer_{{ $loop->iteration }}_5">{{ $question->answer_5 }}</label>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="answer[{{ $loop->index }}]" id="answer_{{ $loop->iteration }}_2" class="custom-control-input" value="2">
                                                    <label class="custom-control-label" for="answer_{{ $loop->iteration }}_2">{{ $question->answer_2 }}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="answer[{{ $loop->index }}]" id="answer_{{ $loop->iteration }}_4" class="custom-control-input" value="4">
                                                    <label class="custom-control-label" for="answer_{{ $loop->iteration }}_4">{{ $question->answer_4 }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </ol>
                                @endif
                            <hr>
                            @if ($essay->count()>0)
                                <p>Essay</p>
                                @foreach ($essay as $item)
                                    <input type="hidden" name="essay[]" value="{{ $item['id'] }}">
                                    <p> <span class="py-1 px-2 bg-warning rounded-circle text-white mr-3">{{ $loop->iteration }}</span> {{ strip_tags($item['question']) }}</p>
                                    <div class="form-group">
                                        <textarea name="essay_answer[]" class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="form-group">
                                {{-- <a href="{{ route('classroom.index') }}" class="btn btn-danger btn-sm">Cancel</a> --}}
                                <button type="submit" onclick="return confirm('Apakah anda sudah yakin?')" class="btn btn-primary btn-sm float-right">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card no-b my-3 shadow">
                    <div class="card-header bg-white">
                        <h6>Informasi Quiz</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category"><strong>Kategori</strong></label>
                            <input type="text" id="category" value="{{ $quiz->category }}" disabled
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="questions"><strong>Jumlah Pertanyaan</strong></label>
                            <input type="text" id="questions" value="{{ $data->count() + $essay->count() }}" disabled
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description"><strong>Deskripsi</strong></label>
                            <textarea id="description" rows="5" class="form-control"
                                      disabled="true">{{ strip_tags($quiz['description']) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="chat-bar-collapsible">
        <button id="chat-button" type="button" class="collapsible active">Discussion
            <i id="chat-icon" style="color: #fff;" class="fas fa-comment"></i>
        </button>
        <div class="content" style="max-height: 500px;">
            <div class="full-chat-block">
                <!-- Message Container -->
                <div class="outer-container">
                    <div class="chat-container">
                        <!-- Messages -->
                        <div id="chatbox">
                            <h5 id="chat-timestamp"></h5>
                            @foreach ($discussions as $item)
                                @if (Auth::id()!=$item->user_id)
                                    <p class="botText my-2">
                                        <span>{{ $item->message }} <sup class="ml-3 {{ $item->user_id==$classroom['user_id']?'bg-success y-1':'' }}"><small>{{ $item->user_id==$classroom['user_id']?'Guru':$item->user->username }}</small></sup></span>
                                    </p>
                                @else
                                    <p class="userText my-2">
                                        <span><sup class="mr-3 {{ $item->user_id==$classroom['user_id']?'bg-success p-1 rounded':'' }}" ><small>{{ $item->user_id==$classroom['user_id']?'Guru':$item->user->username }}</small></sup> {{ $item->message }}</span>
                                    </p>
                                @endif
                            @endforeach
                            <div id="response"></div>
                        </div>
                        <!-- User input box -->
                        <div class="chat-bar-input-block">
                            <div id="userInput">
                                <input id="textInput" class="input-box" type="text" name="msg" placeholder="Tap 'Enter' to send a message">
                                <p></p>
                            </div>
                            <div class="chat-bar-icons">
                                {{-- <i id="chat-icon" style="color: crimson;" class="fa fa-fw fa-heart" onclick="heartButton()"></i> --}}
                                <i id="chat-icon" style="color: #333;" class="fas fa-paper-plane" onclick="sendMessage()"></i>
                            </div>
                        </div>
                        <div id="chat-bar-bottom">
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/config-tiny.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/chat.js') }}"></script>
    <script>
        let classroomId = @json($classroom['id']);
            Echo.private(`classroom.${classroomId}`)
            .listen('SendMessage', (e) => {
                $('#response').append(e.message);
            })

            $('#textInput').keypress(function (e) {
                if(e.keyCode==13){
                    sendMessage();
                }
            });

            function sendMessage(){
                var url = {!! json_encode(route('send')) !!}
                var text = $('#textInput').val();
                var user_id = {!! json_encode(Auth::id()) !!};
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {message:text,user_id:user_id,classroom_id:classroomId},
                    success: function (data) {
                        $('#textInput').val('');
                        $('#response').append(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
    </script>

@endpush


