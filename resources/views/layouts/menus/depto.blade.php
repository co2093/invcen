<li class="treeview">
	<a href="#">
	  <i class="glyphicon glyphicon-tags"></i> <span>Solicitudes</span>
	  <i class="fa fa-angle-left pull-right"></i>
	</a>  
   <ul class="treeview-menu">
   		
	    <li>
	    	<a href="{{route('requisicion-show')}}">
	    		<i class="glyphicon glyphicon-chevron-right"></i>Nueva solicitud
	    	</a>
	    </li>

	    
	    <li><a href="{{url('requisicion/listar')}}"><i class="glyphicon glyphicon-chevron-right"></i>Solicitudes</a></li>
	   
	    
	   <li><a href="{{url('requisicion/productos')}}"><i class="glyphicon glyphicon-chevron-right"></i>Lista de productos</a></li>
	   

   </ul>
	<a href="{{route('producto.controlexistencia')}}">
		<i class="glyphicon glyphicon-shopping-cart"></i> <span>Existencias</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<a href="{{route('producto.entrega.index')}}">
		<i class="glyphicon glyphicon-transfer"></i> <span>Entregas</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
</li> 

@if($periodo->estado == 1)
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
    </ul>


</li>
@endif

 

