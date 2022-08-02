@extends('layouts.app')
@section('title','Create Classroom - ')
@section('content')
    <style>
        .pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
    </style>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-8">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Baca Materi</h6>
                    </div>
                    <div class="card-body">
                        <div id="example1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.8/pdfobject.min.js" integrity="sha512-MoP2OErV7Mtk4VL893VYBFq8yJHWQtqJxTyIAsCVKzILrvHyKQpAwJf9noILczN6psvXUxTr19T5h+ndywCoVw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var file = @json(asset('file/tes.pdf'));
    PDFObject.embed(file, "#example1");
</script>
@endpush


