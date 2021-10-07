@extends('layouts.template')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Actualizar Usuario</div>
                <div class="panel-body">
                    {!!Form::model($usuario,['route'=>['usuario.update',$usuario->id],'method'=>'patch'])!!}                   
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nombre" value="{{$usuario->name}}" required>

                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ $usuario->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('usuario') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">usuario</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="usuario" value="{{$usuario->usuario}}" required>

                                @if ($errors->has('usuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('Perfil', 'perfil', array('class' =>'col-md-4 control-label' )) !!}
                            <div class="col-md-6">
                                <select name="perfil" class="form-control">
                                    @foreach ($roles as $rol)
                                        @if($rol->id == $usuario->perfil_id)
                                            <option selected value={{$rol->id}} >
                                                {{$rol->name}}
                                            </option>
                                        @else
                                            <option value={{$rol->id}}>
                                                {{$rol->name}}
                                            </option>
                                        @endif
                     
                                    @endforeach
                                </select>
                                <div class="error">
                                    <ul>@foreach($errors->get('unidad') as $msg)<li>{{$msg}}</li> @endforeach</ul>
                                </div>              
                            </div>
                        </div>                      
                        <div id="btn_pass" onclick="mostrarPass()">
                            <a href="#">Establecer Contraseña</a>
                        </div>
                        <div id="div_pass">
                           <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">contraseña</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password" >

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Confirmar contraseña</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation" >

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Activo : </label>

                            <div class="col-md-6">
                               @if($usuario->activo=='true')
                               <label><input checked="checked" type="radio" name="activo" value="true">Si</label>
                                <label><input type="radio" name="activo" value="false">No</label>                             
                               @else
                                <label><input  type="radio" name="activo" value="true">Si</label>
                                <label><input  checked="checked" type="radio" name="activo" value="false">No</label>
                               @endif
                                                       
                            </div>
                        </div> 

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="{{Route('usuario.index')}}"><button type="button" id="cancelar" class="btn btn-default m-t-10">Cancelar</button></a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Actualizar
                                </button>
                            </div>
                        </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script >
function mostrarPass(){
document.getElementById('div_pass').style.display = 'block';}
</script>
@endsection
