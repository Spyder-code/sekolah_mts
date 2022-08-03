@extends('layouts.app')
@section('title','Classroom - ')
@section('content')
    <header class="white b-b p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <h3>Point</h3>
                    <span>Point Saya</span>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card shadow my-3 no-b">
                            <div class="card-body bg-pattern">
                                <h3 class="mb-1">Poin Saya</h3>
                                <strong>Total : {{ Auth::user()->point }}</strong><br>
                            </div>
                            {{-- <div class="p-2 b-t">
                                <span class="float-right">
                                    <a href="{{ route('moneybox.siswa.detail',$item->first()->money_box_category->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                                </span>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card no-b my-3 shadow">
                            <div class="card-header white">
                                <h6>Riwayat Point</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover dataTable" id="data-table">
                                        <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($points as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>Membaca Materi {{ $item->course->title }}</td>
                                                <td>{{ $item->point }}</td>
                                                <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
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
