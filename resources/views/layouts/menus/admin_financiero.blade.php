 <li class="treeview">
    <a href="#">
      <i class="glyphicon glyphicon-tags"></i> <span>Solicitudes</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
     <ul class="treeview-menu">
         <li><a href="{{url('requisicion/listar')}}"><i class="glyphicon glyphicon-chevron-right"></i>Solicitudes</a></li>
         <li><a href="{{route('requisicion-financiero')}}"><i class="glyphicon glyphicon-chevron-right"></i>Historial de solicitudes</a></li>
        <li><a href="{{route('requisicion.resumen')}}"><i class="glyphicon glyphicon-chevron-right"></i>Resumen solicitudes</a></li>
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
                <li><a href="{{route('plandecompras.individual')}}"><i class="glyphicon glyphicon-chevron-right"></i>Plan Individual</a></li>

        <li><a href="{{route('plandecompras.resumen')}}"><i class="glyphicon glyphicon-chevron-right"></i>Resumen</a></li>
        <li><a href="{{route('plandecompras.habilitar')}}"><i class="glyphicon glyphicon-chevron-right"></i>Habilitar plan de compras</a></li>
    </ul>
</li>
