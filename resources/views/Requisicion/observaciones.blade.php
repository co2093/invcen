@extends('layouts.template')
@section('css')
    <style>
        .margen{
            margin-bottom: 7px;
        }
    </style>
    @endsection

@section('content')

<h3>Unidad/Usuario: {{$requisicion->departamento['name']}}</h3>
<div class="panel panel-info">
    <div class="panel-heading" role="tab">
        <h4 class="panel-title">
            <strong>Observaci&oacute;n</strong>
        </h4>
    </div>
    <div class="panel-body">
<div class="form-horizontal">

    {!!Form::open(['route'=>'requisicion.detalle.store','method'=>'POST'])!!}

    <div class="form-group">
           <label class="control-label"></label>
           <div class="col-md-11">
       <textarea class="form-control" name="observaciones" rows="6" >{{$requisicion->observacion}}</textarea>
       <input type="hidden" name="id" value="{{$requisicion->id}}">
           </div>
       </div>

          <div class="form-group">

             <div class="col-md-11">
              {!!Form::submit('Guardar',['name'=>'aceptar','id'=>'aceptar','content'=>'<span>Acpetar</span>','class'=>'btn btn-primary'])!!}
             </div>
          </div>   
    {!!Form::close()!!}              
  </div>
    </div>
</div>

     
@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection