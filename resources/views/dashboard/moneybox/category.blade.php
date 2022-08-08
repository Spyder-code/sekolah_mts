@extends('layouts.app')
@section('title','Kategori Tabungan - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                <div class="card p-3">
                    <div class="card-title">
                        Tambah Data
                    </div>
                    <form action="{{ route('moneyboxcategory.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card no-b my-3 shadow">
                    <div class="card-header bg-primary">
                        <h6 class="text-white">List Kategori</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover dataTable" id="data-table">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jenis Tabungan</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($moneyBoxCategories as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td class="d-flex">
                                            <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-{{ $item->id }}"><i class="icon icon-pen"></i>Edit</button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="edit-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="edit-{{ $item->id }}Label" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                    <form action="{{ route('moneyboxcategory.update', $item) }}" method="post" class="modal-content">
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
                                                                <label for="name">Nama</label>
                                                                <input type="text" class="form-control" name="name" value="{{ $item->name }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            <form action="{{ route('moneyboxcategory.destroy',$item) }}" method="post">
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
