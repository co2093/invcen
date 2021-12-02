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
    
 <!--   {!! Html::script('js/filter.js') !!} -->

 <script type="text/javascript">

    

 </script>

@endsection