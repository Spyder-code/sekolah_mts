<!DOCTYPE html>
<html lang="zxx">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <link rel="icon" href="{{ asset('img/icon/icon-notebook.png') }}" type="image/x-icon">
   <title>@yield('title') E-Learning</title>
   <!-- CSS -->
   <link rel="stylesheet" href="{{ asset('css/main.css') }}">
   <link rel="stylesheet" href="{{ asset('css/backend/style.css') }}">
   <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
   @stack('css')
   @yield('writty')
</head>

<body class="light">
   @include('partials.loader')
   <div id="app">
      @if(url()->current() != route('login') && url()->current() != route('register'))
      @include('partials.sidebar')
      <div class="page has-sidebar-left">
         @include('partials.navbar')
            {{-- error message bootstrap --}}
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ Session::get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            {{-- end error message bootstrap --}}
         @yield('content')
      </div>
      @else
      @yield('content')
      @endif
   </div>
   <!--/#app -->
   <script src="{{ asset('js/main.js') }}"></script>
   <script src="{{ asset('js/backend/sweetalert.min.js') }}"></script>
   <script src="{{ asset('js/app.js') }}"></script>
   @stack('js')
   <script>
   $('.custom-file-input').on('change', function(e) {
      var fileName = e.target.files[0].name;
      $(this).next('.custom-file-label').html(fileName);
   });
   </script>
</body>

</html>
