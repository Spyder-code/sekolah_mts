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
    <script>
        Echo.channel(`room`)
        .listen('newMessage', (e) => {
            console.log(e);
        });
    </script>
</body>
</html>
