<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, pariatur. Omnis dicta nulla eveniet aperiam quisquam dolor! Ipsum, provident cupiditate eaque quae temporibus sit excepturi hic perspiciatis commodi facilis eius.</p>
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
        // unloaded event
        var timeout;

        $(window).on('beforeunload', function (){
            timeout = setTimeout(function() {
                console.log('stay');
            }, 1000);
            return "You save some unsaved data, Do you want to leave?";
        });

        $(document).ready(function () {
            var idleState = false;
            var idleTimer = null;
            $('*').bind('mousemove click mouseup mousedown mouseenter scroll dblclick', function () {
                clearTimeout(idleTimer);
                if (idleState == true) {
                    $("body").css('background-color','#fff');
                }
                idleState = false;
                idleTimer = setTimeout(function () {
                    console.log('no activity');
                    $("body").css('background-color','#000');
                    idleState = true; }, 30000);
            });
        });
    </script>
</body>
</html>
