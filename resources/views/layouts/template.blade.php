<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CENSALUD</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/font-awesome.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.css')}}">

    <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.css')}}">

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href=" {{ asset('bootstrap/css/bootstrap.css') }}">


    <!-- our styles -->
    <link rel="stylesheet" href=" {{ asset('bootstrap/css/style.css') }}">
    <!-- estilo para datatables -->
    <link rel="stylesheet" href="{{asset('plugins/datatables/jquery.dataTables.min.css')}}">

    {!! Html::style('plugins/alertifyjs/css/alertify.min.css') !!} 
    {!! Html::style('plugins/alertifyjs/css/themes/default.min.css') !!} 
@yield('css')

<!-- jQuery-->
    <!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script> -->
    <script src="{{asset('plugins/jQuery/jQuery.js')}}"></script>


</head>

<body class="hold-transition skin-red sidebar-mini">

<div class="wrapper">
    <header class="main-header" style="background-color: #aa0000;">

        <!-- Logo wrapper-->
        <!-- Header Navbar: style can be found in header.less -->

        <div class="logo navbar-fixed-top">
            <!-- logo for regular state and mobile devices -->
            
            <div>
                <span class="logo-lg"><b>CENSALUD</b></span>
            </div>

        </div>
        <!-- barra titulo-->

        <nav class="navbar navbar-inverse navbar-fixed-top " role="navigation" >

            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">MENU</span>
            </a>

            <!-- Navbar Right Menu (menu derecho de mensajeria no estan necesario) -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- Nombre del usuario en barra de menu -->
                            <img src="{{asset('dist/img/icono_persona.png')}}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{Auth::user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{route('usuario.edit',Auth::user()->id)}}"
                                       class="btn btn-default btn-flat">EditarPerfil</a>
                                    <a href="{{url('logout')}}" class="btn btn-default btn-flat">Salir</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->

        <!--seccion de menus a la izquierda -->
        <section class="sidebar">

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
               

                <li class="treeview">
                    <a href="{{url('home')}}">
                        <i class="fa fa-home"></i> <span>INICIO</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                @if (Auth::user()->perfil['name'] == 'ADMINISTRADOR BODEGA')
                    @include('layouts.menus.admin_bodega')
                @else
                    @if (Auth::user()->perfil['name'] == 'DEPARTAMENTO')
                        @include('layouts.menus.depto')
                    @else
                        @if (Auth::user()->perfil['name'] == 'ADMINISTRADOR FINANCIERO')
                            @include('layouts.menus.admin_financiero')
                        @else
                            @if (Auth::user()->perfil['name'] == 'ADMINISTRADOR SISTEMA')
                                @include('layouts.menus.admin_sistema')
                            @else
                                @if(Auth::user()->perfil['name'] == 'ADMINISTRADOR EQUIPO')
                                    @include('layouts.menus.admin_equipo')
                                @endif
                            @endif
                        @endif
                    @endif
                @endif

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>


    <!-- Content Wrapper. Contains page content content-wrapper-->
    <div class="content-wrapper">
        <div class="container col-md-12">
            <div class="col-md-12">

                @if (session()->has('flash_notification.message'))
                    <div class="alert alert-{{ session('flash_notification.level') }} " id="msj">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session('flash_notification.message') !!}
                    </div>
                @endif

                @yield('content')

            </div>
        </div>
    </div> <!-- /.content-wrapper -->


    <footer class="main-footer">
        <strong>Copyright &copy; 2018 CENSALUD, Todos los derechos reservados.</strong>
    </footer>


</div><!-- ./wrapper -->

<!-- AdminLTE App-->
<script src="{{asset('dist/js/app.js')}}"></script>

<!-- para poner mascaras a los input-->
<script src="{{asset('plugins/input-mask/jquery.inputmask.js')}}"></script>

<!-- Script de la tabla -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>

{!! Html::script('plugins/alertifyjs/alertify.min.js') !!}

<!-- js de bootstrap-->
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script>
    $('#msj').delay(4000).fadeOut(1000);
</script>
@yield('script')

</body>
</html>