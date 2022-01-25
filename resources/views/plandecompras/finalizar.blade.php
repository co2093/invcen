@extends('layouts.template')

@section('content')

<div class="container">
<div class="panel panel-danger">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title text-center">
				<strong>REINICIAR</strong>
			</h4>
		</div>
		
                <div class="panel-body text-center">                   
                                <label class="control-label text-danger">Con esta acción se daría por finalizado el período de compras y se reiniciaría todo el plan de compras.</label> 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3"><br>
                                <a href="{{ route('plandecompras.finalizar.confirmar') }}" class="btn btn-danger btn-block">CONFIRMAR</a>
                            </div>
                        </div>
               


       
        </div>	
</div>
</div>


@endsection