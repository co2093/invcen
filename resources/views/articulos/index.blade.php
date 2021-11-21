@extends('layouts.template')

@section('content')

<div class="encabezado">
<h3>Productos</h3>
</div>
<a href="{{ route('articulo.create')}}" class="btn btn-success" title="Nuevo producto"><span class="glyphicon glyphicon-plus"></span>Nuevo</a>

<div class="table-responsive">
<table class="table table-hover table-striped table-bordered table-condensed" id="TablaArticulo" >
    <thead>
            <th>Categoría
                <select name="category_filter" id="category_filter" class="form-control">
                    <option>Seleccione la Categoría</option>
                        @foreach($especificos as $row)
                            <option value="{{ $row->id }}">{{ $row->titulo_especifico }}</option>            
                        @endforeach           
                </select>
            </th>
            <th>C&oacute;d. prod.</th>
            <th>Producto</th>
	        <th>Unidad de medida</th>
	        <th>Opciones</th>
	    </tr>
	</thead>
<tbody>
 


</tbody>  
</table>
</div>

@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){
fetch_data();
function fetch_data(especificos = '')
{

  $('#TablaArticulo').DataTable({
   processing: true,
   serverSide: true,
    ajax: {
    url:"{{ route('articulo.index') }}",
    data: {especificos:especificos}
 },
   columns:[
    {
     data: 'titulo_especifico',
     name: 'titulo_especifico'
     orderable: false
    },
    {
     data: 'codigo_articulo',
     name: 'codigo_articulo'
    },
    {
     data: 'nombre_articulo',
     name: 'nombre_articulo',
    },
    {
     data: 'nombre_unidadmedida',
     name:'nombre_unidadmedida'
    }

   ]

  });

}

$('#category_filter').change(function(){
    var category_id = $('#category_filter').val();

    $('#TablaArticulo').DataTable().destroy();

    fetch_data(category_id);
});

});

</script>
@endsection