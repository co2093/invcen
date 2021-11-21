<li class="treeview">
    <a href="#">
        <i class="glyphicon glyphicon-list-alt"></i> <span>Articulos</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{url('articulo')}}"><i class="glyphicon glyphicon-chevron-right"></i>Productos</a></li>
        <li><a href="{{url('unidad')}}"><i class="glyphicon glyphicon-chevron-right"></i>Unidad de Medida</a></li>
        <li><a href="{{url('especifico')}}"><i class="glyphicon glyphicon-chevron-right"></i>Categorias</a></li>

    </ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="glyphicon glyphicon-shopping-cart"></i> <span>Transacciones</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ route('ingreso.index')}}"><i class="glyphicon glyphicon-chevron-right"></i>Entradas</a></li>
        <li><a href="{{url('descargo')}}"><i class="glyphicon glyphicon-chevron-right"></i>Salidas</a></li>
        <li><a href="{{url('transaccion')}}"><i class="glyphicon glyphicon-chevron-right"></i>Kardex</a></li>
        <li><a href="{{url('existencia')}}"><i class="glyphicon glyphicon-chevron-right"></i>Existencia</a></li>
        <li><a href="{{ route('oferta_demanda')}}"><i class="glyphicon glyphicon-chevron-right"></i>Oferta y demanda</a></li>
    </ul>
</li>

<li class="treeview">
    <a href="{{url('departamento')}}">
        <i class="glyphicon glyphicon-object-align-vertical"></i> <span>Unidad/Usuario</span>
      
    </a>
</li>

<li class="treeview">
    <a href="{{url('proveedor')}}">
        <i class="glyphicon glyphicon-shopping-cart"></i> <span>Proveedores</span>
       
    </a>
</li>

<li class="treeview">
    <a href="#">
        <i class="glyphicon glyphicon-tags"></i> <span>Solicitudes</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

        @if($periodo->estado == 1)

        <li><a href="{{url('requisicion/listar')}}"><i class="glyphicon glyphicon-chevron-right"></i>Solicitudes</a></li>
        <li><a href="{{route('habilitar-envios')}}"><i class="glyphicon glyphicon-chevron-right"></i>Habilitar Envios</a></li>

        @endif
        <li><a href="{{route('requisicion.resumen')}}"><i class="glyphicon glyphicon-chevron-right"></i>Plan de compras</a></li>

    </ul>
</li>
<li class="treeview">
    <a href="{{route('reportes')}}">
        <i class="glyphicon glyphicon-file"></i> <span>Reportes</span>
        
    </a>
</li>

