@extends('layouts.app')
@section('title','Classroom - ')
@section('content')
    <header class="white b-b p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <h3>Kelas {{ $room->room->name}}</h3>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center">Ranking Kelas</h1>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:20px" scope="col">Peringkat</th>
                                    <th class="text-center" style="vertical-align : middle;text-align:center; font-weight:bold" scope="col">Nama</th>
                                    <th class="text-center" style="vertical-align : middle;text-align:center; font-weight:bold" scope="col">Nilai Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['score'] }}</td>
                                    </tr>
                                @endforeach
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
