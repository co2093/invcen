@extends('layouts.template')

@section('content')
<div class="container">
 @include('Msj.messages')  
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Ingresar Rol</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('roles.store') }}" autocomplete="off">
                        {{ csrf_field() }}                      

                        <div class="form-group">
                            <label class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required>

                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>   
                        <div class="form-group">
                            <label class="col-md-4 control-label">Descripcion</label>

                            <div class="col-md-6">
                                <textarea  class="form-control" name="descripcion" value="{{ old('descripcion') }}" required></textarea>

                                @if ($errors->has('descripcion'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descripcion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>         

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrar
                                </button>
                                <a href="javascript:window.history.back();"><button type="button" id="cancelar" class="btn btn-default m-t-10">Cancelar</button></a>                                    
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
