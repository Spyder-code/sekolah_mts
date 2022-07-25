@extends('layouts.app')
@section('title','Quiz Result History - ')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')
    <div class="container-fluid my-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{ route('classroom.show',['classroom'=>$quiz->classroom_id]) }}" class="btn btn-danger btn-sm">Back</a>
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Quiz {{ $quiz->name }}</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                            <tr>
                                <th width="8%">No</th>
                                <th>Nama siswa</th>
                                <th>Nilai</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->student->name }}</td>
                                    <td>{{ $item->score }}</td>
                                    <td>
                                        @if ($item->status==0)
                                            <div class="alert alert-danger">
                                                <strong>Belum mengerjakan</strong>
                                            </div>
                                        @elseif($item->status==1)
                                            <div class="alert alert-info">
                                                <strong>Belum dinilai</strong>
                                            </div>
                                        @else
                                            <div class="alert alert-success">
                                                <strong>Complete</strong>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status==1)
                                            <a href="{{ route('quiz.detail',['classroom'=>$quiz->classroom_id,'quiz_result'=>$item->id]) }}" class="btn btn-sm btn-warning">Nilai siswa</a>
                                        @elseif($item->status==2)
                                            <a href="{{ route('quiz.detail',['classroom'=>$quiz->classroom_id,'quiz_result'=>$item->id]) }}" class="btn btn-sm btn-info">Lihat pekerjaan</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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

    <script>
        $('.dataTable').DataTable({
            "columnDefs": [{
                "orderable": false
            }],
            "responsive": true,
            "pageLength": 10,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ per halaman",
                "zeroRecords": "Tidak ada data",
                "info": "Tampilkan _PAGE_ dari _PAGES_ halaman",
                "infoEmpty": "",
                "search": "Cari Data :",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                }
            }
        });
    </script>
@endpush

