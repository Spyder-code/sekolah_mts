@extends('layouts.app')
@section('title','Classroom - ')
@section('content')
    <header class="white b-b p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <h3>Tabungan</h3>
                    <span>Daftar Tabungan Saya</span>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    @forelse($moneyBoxesTotal as $item)
                        <div class="col-md-3">
                            <div class="card shadow my-3 no-b">
                                <div class="card-body bg-pattern">
                                    <h3 class="mb-1">{{ $item->first()->money_box_category->name }}</h3>
                                    <strong>Total :</strong><br> Rp.{{ number_format($item->sum('amount')) }}
                                </div>
                                {{-- <div class="p-2 b-t">
                                    <span class="float-right">
                                        <a href="{{ route('moneybox.siswa.detail',$item->first()->money_box_category->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                                    </span>
                                </div> --}}
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div class="card shadow my-3 no-b">
                                <div class="card-body text-center pt-5 pb-5">
                                    <div class="center" style="font-size:28px; font-weight: bold">Oops !</div>
                                    <div class="center" style="font-size:18px">Kamu belum pernah menabung</div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card no-b my-3 shadow">
                            <div class="card-header white">
                                <h6>Riwayat Tabungan</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover dataTable" id="data-table">
                                        <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Jenis Tabungan</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal Menabung</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($moneyBoxes as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->money_box_category->name }}</td>
                                                <td>Rp.{{ number_format($item->amount) }}</td>
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
