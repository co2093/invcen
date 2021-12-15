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
        <i class="glyphicon glyphicon-tags"></i> <span>Solicitudes</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{route('habilitarPeriodo')}}"><i class="glyphicon glyphicon-chevron-right"></i>Periodo</a></li>
    </ul>
</li>



<li class="treeview">
    <a href="#">
        <i class="glyphicon glyphicon-folder-close"></i> <span>Plan de compras</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i>Iniciar plan de compras</a></li>
        <li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i>Habilitar plan de compras</a></li>
    </ul>
</li>

