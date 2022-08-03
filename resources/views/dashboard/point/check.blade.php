@extends('layouts.app')
@section('title','Classroom - ')
@section('content')
    <header class="white b-b p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <h3>Point</h3>
                    <span>Point Siswa</span>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card no-b my-3 shadow">
                            <div class="card-header white">
                                <h6>Point Siswa</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover dataTable" id="data-table">
                                        <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Siswa</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item['user'] }}</td>
                                                <td>{{ $item['point'] }}</td>
                                                <td>{{ $item['tgl'] }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
