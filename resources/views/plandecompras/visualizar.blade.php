@extends('layouts.template')

@section('content')
<div class="container">

	<div class="panel panel-info">

	<div class="panel-heading"></div>
    	<div class="panel-body">
    		<a class="btn btn-danger btn-sm"  title="Eliminar Cotización" href="{{route('plandecompras.visualizar', $cotizacion)}}">
                <span class="fa fa-trash fa-2x"></span>
            </a>
    	</div>
  	</div>
    <iframe src="https://docs.google.com/viewer?url=$archivo&embedded=true" width="600" height="780" style="border: none;"></iframe>
</div>
</div>



@endsection