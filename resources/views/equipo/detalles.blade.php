@extends('layouts.template')
@section('css')
	<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
@endsection

@section('content')
<div class="panel panel-primary">	
	<div class="panel-heading">
    	<h3 class="panel-title">Detalle de equipo</h3>
	</div>
	<div class="panel-body">
	    <div class="row">
	      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">     		  
	    		<div class="panel with-nav-tabs panel-success">
	          <div class="panel-heading">
	            <ul class="nav nav-tabs">
	              <li class="active"><a href="#panel-generales" data-toggle="tab">Datos Generales</a></li>
	              <li><a href="#panel-bitacora" data-toggle="tab">Bit&aacute;cora</a></li>                 
	            </ul> 
	          </div>
	          <div id="panel-collapse-1" class="collapse in">
	            <div class="panel-body">
	              <div class="tab-content">
	                  	{{-- panel generales --}}
		                  @include('equipo.panel.generales')
		                {{-- /panel generales --}}

		                {{-- panel bitacora --}}
		                  @include('equipo.panel.bitacora')
		                {{-- /panel bitacora --}}           

	              </div><!-- /.tab-content -->
	            </div><!-- /.panel-body -->           
	          </div><!-- /.collapse in -->
	        </div>
	        <div class="text-center">
	          <a href="javascript:window.history.back();" style="border: 1px solid black;" type="button" id="cancelar" class="btn btn-default m-t-10"><i class="fa fa-reply-all" aria-hidden="true"></i>Regresar</a>
	        </div>
	      </div>      
	    </div>
	</div>
</div>

@endsection
@section('script')
	<script src="{{asset('plugins/select2/js/select2.js')}}"></script>
	<script type="text/javascript">
        $(document).ready(function() {
            $(".js-example-basic-single").select2();
        });
	</script>
@endsection