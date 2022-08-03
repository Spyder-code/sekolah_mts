@extends('layouts.app')
@section('title','Create Classroom - ')
@push('css')
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>
@endpush
@section('content')
    <style>
        .pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
    </style>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-10">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"  style="width: 0%">0%</div>
                        </div>
                    </div>
                    <div class="col-2" id="get-point">
                        <form action="{{ route('point.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <input type="hidden" name="point" value="1">
                            <button type="submit" class="btn btn-success btn-sm animate__animated animate__bounce">Ambil Point</button>
                        </form>
                    </div>
                </div>

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
    $('#get-point').hide();
    var file = @json(asset('storage/'.$course['files'][0]['filename']));
    if(PDFObject.supportsPDFs){
        PDFObject.embed(file, "#example1");
    } else {
        alert("This browser does not support PDFs");
    }

    function updateProgress(percentage) {
        var progress = document.querySelector('.progress-bar');
        progress.style.width = percentage + '%';
        $('.progress-bar').html(percentage+'%');
    }

    let i = 0;
    let percentage = 1;
    var time = setInterval(() => {
        percentage = Math.ceil((i/180)*100);
        updateProgress(percentage);
        i++;
        if (i==180) {
            stop();
        }
    }, 1000);

    function stop() {
        $('#get-point').show();
        clearInterval(time);
        // ajax
        // $.ajax({
        //     url: '{{ route('addPoint') }}',
        //     type: 'POST',
        //     data:{
        //         user_id: '{{ Auth::id() }}',
        //     },
        //     success: function(data) {
        //         console.log(data);
        //     }
        // });
    }
</script>
@endpush


