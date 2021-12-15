<li class="treeview">
    
        <li><a href="{{route('equipo.lista.tipos')}}">  <i class="fa fa-list-ul"></i>Tipos de equipos</a></li>
        <li><a href="{{route('equipo.lista')}}">  <i class="fa fa-cogs"></i>Equipos</a></li>
        <li><a href="{{route('equipo.reporte')}}" target="_blank">  <i class="fa fa-file-pdf-o"></i>Reporte de equipos</a></li>
    	<li><a href="{{route('equipo.resumen')}}" target="_blank">  <i class="fa fa-file-pdf-o"></i>Resumen de equipos</a></li>
    	<li><a href="{{route('equipo.archivos')}}">  <i class="fa fa-folder"></i>Archivos</a></li>
</li>

@if($periodo->estado == 1)
<li class="treeview">
    <a href="#">
        <i class="glyphicon glyphicon-folder-close"></i> <span>Plan de compras</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i>Iniciar plan de compras</a></li>
    </ul>
</li>
@endif
