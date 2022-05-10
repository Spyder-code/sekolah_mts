@extends('layouts.app')
@section('title','Classroom - ')
@section('content')
    <header class="white b-b p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <h3>Kelas {{ $room->room->name }}</h3>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center">Laporan Hasil Belajar</h1>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="vertical-align : middle;text-align:center; font-weight:bold" scope="col" rowspan="2">#</th>
                                    <th class="text-center" style="vertical-align : middle;text-align:center; font-weight:bold" scope="col" rowspan="2">Mata Pelajaran</th>
                                    <th class="text-center" style="vertical-align : middle;text-align:center; font-weight:bold" scope="col" colspan="{{ $tugas + 2 }}">Nilai</th>
                                </tr>
                                <tr>
                                    @for ($i = 1; $i <= $tugas; $i++)
                                    <th class="text-center" style="vertical-align : middle;text-align:center; font-weight:bold" scope="col">Tugas {{ $i }}</th>
                                    @endfor
                                    <th class="text-center" style="vertical-align : middle;text-align:center; font-weight:bold" scope="col">UTS</th>
                                    <th class="text-center" style="vertical-align : middle;text-align:center; font-weight:bold" scope="col">UAS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas->classroom as $classroom)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <th>{{ $classroom->name }}</th>
                                        @foreach ($classroom->quizzes->where('category','TUGAS') as $quiz)
                                            @foreach ($quiz->result->where('user_id', Auth::id()) as $result)
                                                <th>{{ $result->score }}</th>
                                            @endforeach
                                            @php
                                                $a = $classroom->quizzes->where('category','TUGAS')->count();
                                            @endphp
                                        @endforeach
                                        @if ($a < $tugas)
                                            @for ($i = 1; $i <= $tugas-$a; $i++)
                                                <th>-</th>
                                            @endfor
                                        @endif
                                        @php
                                            $uts = $classroom->quizzes->where('category','UTS')->first();
                                            $uas = $classroom->quizzes->where('category','UAS')->first();
                                        @endphp
                                        @if ($uts)
                                            @foreach ($uts->result->where('user_id', Auth::id()) as $result)
                                                <th>{{ $result->score }}</th>
                                            @endforeach
                                        @else
                                            <th>-</th>
                                        @endif
                                        @if ($uas)
                                            @foreach ($uas->result->where('user_id', Auth::id()) as $result)
                                                <th>{{ $result->score }}</th>
                                            @endforeach
                                        @else
                                            <th>-</th>
                                        @endif
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" style="vertical-align : middle;text-align:center; font-weight:bold"><strong>Rata-rata</strong></td>
                                    <td colspan="8" class="text-center"><strong>{{ ceil($nilai->sum('score') / $nilai->count()) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group">
                            <button class="btn btn-primary" onclick="window.print()">Cetak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        @if(session()->has('success'))
        swal("Berhasil !", '{{ session()->get('success') }}', "success");
        @endif
    </script>
@endpush
