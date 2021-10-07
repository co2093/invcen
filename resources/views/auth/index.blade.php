@extends('layouts.template')

@section('content')
    <div class="encabezado">
	    <h3>Usuarios</h3>
    </div>	
        <a href="{{url('register')}}" class="btn btn-success" title="Nuevo usuario"><span class="glyphicon glyphicon-plus"></span>Nuevo</a>
     
<div class="panel-body table-responsive">
                   
             @include('Msj.messages')         



            <table id="TablaUsuarios" class="table table-hover table-striped table-bordered table-condensed">       
                <thead>
                <tr class="success">
                      
                        <th >Usuario</th>
                        <th >Nombre</th>
                        <th >Perfil</th>
                        <th>Unidad</th>
                        <th>Opciones</th>
                </tr>
                 
                </thead>
                <tbody>
                   @foreach ($usuarios as $u)
                      <tr>
                              <td>{{$u->usuario}}</td>
                              <td>{{$u->name}}</td>               
                              <td>{{$u->perfil["name"]}}</td>
                          @if($u->departamento)
                              <td>{{$u->departamento->name}}</td>
                              @else
                              <td>N/A</td>
                          @endif
                              <td class="col-md-2">

                              <a class="btn btn-default btn-sm" title="Editar" href="{{url($u->id,'edit')}}"><span class="glyphicon glyphicon-pencil "></span></a>

                              <a class="btn btn-default btn-sm" title="Eliminar" href="{{route('usuario-eliminar',$u->id)}}"><span class="glyphicon glyphicon-trash "></span></a>
                              </td>
                         
                      </tr>
                   @endforeach      
                                      
                </tbody>
            </table>

</div>

 @endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            $("#TablaUsuarios").DataTable(
                {
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true
                });
        });
    </script>
@endsection