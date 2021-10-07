@extends('layouts.template')

@section('content')


<div class="panel-body table-responsive">
       
    <div class="box-header with-border">
      <h3 class="box-title">Reporte Mensual de Existencias</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="form-horizontal">
       {!!Form::open(['route'=>['existencias.mensual'],'method'=>'post'])!!}
           {{ csrf_field() }}
    
			<div class="panel panel-default">
				
				<div class="text-center">
					<p><strong>Seleccion el Primer dia Del Mes</strong></p>
				</div>
				<div class="form-group">
					{!!Form::label('Fecha', 'Fecha Inicial', array('class' =>'col-md-2 control-label' )) !!}
					<div class="col-md-7">

    				{!!Form::date('fecha_ini', null, array('placeholder' => 'YYYY-mm-dd','class' => 'form-control calendario')) !!}				
					</div>
		 		</div>		

        <div class="text-center">
          <p><strong>Seleccion el Ultimo dia Del Mes</strong></p>
        </div>
        <div class="form-group">
          {!!Form::label('Fecha', 'Fecha Final', array('class' =>'col-md-2 control-label' )) !!}
          <div class="col-md-7">

            {!!Form::date('fecha_fin', null, array('placeholder' => 'YYYY-mm-dd','class' => 'form-control calendario')) !!}       
          </div>
        </div>  
       		
			</div>
    
          <div class="">
          		<a href="javascript:window.history.back();"><button type="button" id="cancelar" class="btn btn-default m-t-10">Regresar</button></a>
                <button type="submit" class="btn btn-danger">Generar</button>
          </div><!-- /.box-footer -->
       {!!Form::close()!!}
   </div>
       

</div>
 @endsection
 @section('script')
<script src="{{asset('bootstrap/js/jquery-ui.min.js')}}"></script>
 <script>
         $(function() {
            $( ".calendario" ).datepicker({
               appendText:"(yy-mm-dd)",
               dateFormat:"yy-mm-dd",
               
            });
         });
 </script>
@endsection
@section('css')
 <link rel="stylesheet" href=" {{ asset('bootstrap/css/jquery-ui.min.css') }}">
@endsection



