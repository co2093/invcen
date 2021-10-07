@extends('layouts.template')

@section('content')

    <div>
        <h1>INVENTARIO CENSALUD-UES</h1>
    </div>
    <div class="container">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
                <li data-target="#myCarousel" data-slide-to="4"></li>
                <li data-target="#myCarousel" data-slide-to="5"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="{{asset('dist/img/departamentos.png')}}" alt="Departamentos">
                </div>

                <div class="item">
                    <img src="{{asset('dist/img/inventario.png')}}" alt="Articulos">
                </div>

                <div class="item">
                    <img src="{{asset('dist/img/proveedores.png')}}" alt="Proveedores">
                </div>

                <div class="item">
                    <img src="{{asset('dist/img/requisicion.png')}}" alt="Requisiciones">
                </div>

                <div class="item">
                    <img src="{{asset('dist/img/usuarios.png')}}" alt="Usuarios">
                </div>

                <div class="item">
                    <img src="{{asset('dist/img/informes.png')}}" alt="Informes">
                </div>

            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>
        <hr/>


    </div>

    <div class="text-justify">
        <h3>
            INVENTARIO CENSALUD-UES es un sistema inform&aacute;tico pensado para facilitar
            la administración del inventario del Centro de Investigaci&oacute;n y Desarrollo en Salud de la Universidad
            de El Salvador.
        </h3>
    </div>

@endsection