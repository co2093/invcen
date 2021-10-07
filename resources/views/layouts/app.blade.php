<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIGinventario</title>

    <!-- Fonts & Styles -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('bootstrap/css/bootstrap.min.css') }}">


    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <div class="pull-left">
                <img
                        src="{{asset('dist/img/minerva.png')}}"
                        class="logo"
                        alt="logo Image"
                        style="width: 30%; height:30%; "
                        id='logo'>
            </div>
            <!-- Branding Image -->
            <div class="navbar-brand" href="{{ url('/') }}">
                SIGinventario, CENSALUD.
            </div>
        </div>


    </div>
</nav>

@yield('content')

<!-- JavaScripts -->
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
