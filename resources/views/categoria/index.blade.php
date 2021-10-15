@extends('layouts.template')

@section('content')
<div class="encabezado">
<h3>Categorías</h3>
</div>
<a href="{{ route('categoria.create')}}" class="btn btn-success" title="Nueva Categoria"><span class="glyphicon glyphicon-plus"></span>Nuevo</a>

<div class="table-responsive">
<table class="table table-hover table-striped table-bordered table-condensed" id="TablaCategoria" >
    <thead>
        <tr class="success">
            <th>Código</th>
            <th>Nombre</th>
            <th>Descripci&oacute;n</th>
            <th>Opciones</th>
	    </tr>
	</thead> 
    <tbody>
 
        @foreach ($categorias as $categoria)
            <tr>
                <td>{{$categoria->id_categoria}}</td>
                <td>{{$categoria->nombre}}</td>
                
                @if(empty($categoria->descripcion))
                    <td>Ninguna descripción asignada para la Categoría</td>
                @else
                    <td>{{$categoria->descripcion}}</td>
                @endif
                
        
                <td class="col-md-3">
                    <a class="btn btn-default btn-sm" href="{{route('delete_categoria',$categoria->id_categoria)}}" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a>
                    <a class="btn btn-default btn-sm" href="{{route('categoria.show',$categoria->id_categoria)}}" title="Detalle"><span class="glyphicon glyphicon-th-large"></span></a>
                    <a class="btn btn-default btn-sm" href="{{route('categoria.edit',$categoria->id_categoria)}}" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>
                </td>
                
            </tr>
         @endforeach
        
        </tbody>  
</table>
</div>

@endsection


