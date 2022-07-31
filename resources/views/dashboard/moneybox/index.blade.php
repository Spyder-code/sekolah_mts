@extends('layouts.app')
@section('title','Tabungan Siswa ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                <div class="card p-3">
                    <div class="card-title">
                        Tambah Data
                    </div>
                    <form action="{{ route('moneybox.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Siswa</label>
                            <select name="user_id" class="form-control" required>
                                <option></option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Kategori Tabungan</label>
                            <select name="money_box_category_id" class="form-control" required>
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Nominal</label>
                            <input type="number" class="form-control" name="amount" required>
                        </div>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>List Tabungan</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover dataTable" id="data-table">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Siswa</th>
                                    <th>Jenis Tabungan</th>
                                    <th>Jumlah</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($moneyBoxes as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->student->name }}</td>
                                        <td>{{ $item->money_box_category->name }}</td>
                                        <td>Rp.{{ number_format($item->amount) }}</td>
                                        <td class="d-flex">
                                            <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-{{ $item->id }}"><i class="icon icon-pen"></i>Edit</button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="edit-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="edit-{{ $item->id }}Label" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                    <form action="{{ route('moneybox.update', $item) }}" method="post" class="modal-content">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="edit-{{ $item->id }}Label">Edit</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="name">Jenis Tabungan</label>
                                                                <select name="money_box_category_id" class="form-control">
                                                                    @foreach ($categories as $category)
                                                                        <option value="{{ $category->id }}" {{ $category->id==$item->money_box_category_id?'selected':'' }}>{{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="amount">Amount</label>
                                                                <input type="text" class="form-control" name="amount" value="{{ $item->amount }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            <form action="{{ route('moneybox.destroy',$item) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs"><i class="icon icon-trash"></i>Hapus</button>
                                            </form>
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
    </div>
@endsection
