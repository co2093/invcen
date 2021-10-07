@extends('layouts.template')

@section('content')
    <div class="encabezado">
	    <h3>Roles</h3>
	</div>
         
        <a href="{{route('roles.create')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>Nuevo</a>
     
<div class="panel-body table-responsive">
                   
             @include('Msj.messages')                 
            
            <table class="table table-hover table-striped table-bordered table-condensed" id="TablaProveedores">       
                <thead class="row">                    
                        <th class="col-md-4">NOMBRE</th>
                        <th class="col-md-8">DESCRIPCION</th>              
                </thead>
                <tbody>
                   @foreach ($roles as $r)
                      <tr>
                              <td>{{$r->name}}</td>
                              <td>{{$r->description}}</td>                  
                      </tr>
                   @endforeach      
                                      
                </tbody>
            </table>

</div>
 @endsection
 @section('script')
<script type="text/javascript">
 
 
</script>

@endsection