{{-- Menu del administrador del sistema informatico--}}

<li class="treeview">
    <a href="#">
        <i class="glyphicon glyphicon-user"></i> <span>Usuarios</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{url('usuario')}}"><i class="glyphicon glyphicon-chevron-right"></i>Usuarios</a></li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="glyphicon glyphicon-folder-close"></i> <span>Plan de compras</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{route('plan.index')}}"><i class="glyphicon glyphicon-chevron-right"></i>Iniciar plan de compras</a></li>
    </ul>
    <ul class="treeview-menu">
        <li><a href="{{route('plandecompras.historial')}}"><i class="glyphicon glyphicon-chevron-right"></i>Historial</a></li>

        <li><a href="{{route('plandecompras.resumen')}}"><i class="glyphicon glyphicon-chevron-right"></i>Resumen</a></li>
    </ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="glyphicon glyphicon-folder-close"></i> <span>Administrar Plan</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>

    <ul class="treeview-menu">

                <li><a href="{{route('plandecompras.individual')}}"><i class="glyphicon glyphicon-chevron-right"></i>Plan Individual</a></li>

        <li><a href="{{route('plandecompras.resumen')}}"><i class="glyphicon glyphicon-chevron-right"></i>Resumen</a></li>

        <li><a href="{{route('plandecompras.habilitar')}}"><i class="glyphicon glyphicon-chevron-right"></i>Habilitar plan de compras</a></li>
    </ul>
</li>

