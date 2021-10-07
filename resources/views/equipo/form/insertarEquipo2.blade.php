{{-- modal para asignar los equipos a la requisicion --}}

<div class="modal fade" id="dlgInsertarEquipo" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
               
                <h4 class="modal-title">
                    INSERTAR EQUIPO 
                </h4>

            </div>
                
            <!-- Modal Body -->
            <div class="modal-body">               
                <form action="{{route('equipo.insertar')}}" method="POST" class="form form-vertical" role="form" id="insertarEquipo" autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">        
                    <input type="hidden" name="id_equipo" id="id_equipo" value="">
                    <div class="row" width="100%">
                        <div class="form-group col-md-12">
                          <div class="input-group">
                            <div class="input-group-addon"><b>TIPO DE EQUIPO</b></div>            
                            <select class="form-control" id="tipoEquipo" name="tipoEquipo">
                              <option value="">Seleccione</option>
                              @foreach($tipos as $tipo)
                               <option value="{{$tipo->id_tipo_equipo}}">{{$tipo->nombre_tipo_equipo}}</option>
                              @endforeach
                            </select>   
                          </div>
                        </div> 
                        <div class="form-group col-md-12">
                          <div class="input-group">
                            <div class="input-group-addon"><b>NÚMERO INVENTARIO</b></div>                       
                            <input type="text" class="form-control" id="numInventario" name="numInventario">         
                          </div>
                        </div>      
                        <div class="form-group col-md-12">
                          <div class="input-group">
                            <div class="input-group-addon"><b>NÚMERO DE SERIE</b></div>                       
                            <input type="text" class="form-control" id="numSerie" name="numSerie">         
                          </div>
                        </div>
                        <div class="form-group col-md-12">
                          <div class="input-group">
                            <div class="input-group-addon"><b>MODELO</b></div>                       
                            <input type="text" class="form-control" id="modelo" name="modelo">         
                          </div>
                        </div>
                        <div class="form-group col-md-12">
                          <div class="input-group">
                            <div class="input-group-addon"><b>DESCRIPCIÓN</b></div>                       
                            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>         
                          </div>
                        </div>
                        <div class="form-group col-md-12">
                          <div class="input-group">
                            <div class="input-group-addon"><b>OBSERVACIÓN</b></div>                       
                            <textarea class="form-control" id="observacion" name="observacion"></textarea>        
                          </div>
                        </div>  
                        <div class="form-group col-md-12">
                          <div class="input-group">
                            <div class="input-group-addon"><b>ESTADO</b></div>            
                            <select class="form-control" id="estado" name="estado">
                              <option value="">Seleccione</option>
                              @foreach($estados as $estado)
                               <option value="{{$estado->idestado}}">{{$estado->estado}}</option>
                              @endforeach
                            </select>   
                          </div>
                        </div>                      
                        <div class="form-group col-md-12">
                          <div class="input-group">
                            <div class="input-group-addon"><b>RESPONSABLE</b></div>                       
                            <input type="text" class="form-control" id="responsable" name="responsable">         
                          </div>
                        </div>
                        <div class="form-group col-md-12">
                          <div class="input-group">
                            <div class="input-group-addon"><b>UBICACIÓN</b></div>                       
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion">         
                          </div>
                        </div>
                        <div class="form-group col-md-12">
                          <div class="input-group">
                            <div class="input-group-addon"><b>SELECCIONE</b></div>
                            <select name="procedencia" id="procedencia" class="form-control">
                              <option value="compra">Compra</option>
                              <option value="donación">Donación</option>
                              <option value="préstamo">Préstamo</option>
                            </select>         
                          </div>
                        </div> 
                        <div class="form-group col-md-12" id="div_precio">
                          <div class="input-group">
                            <div class="input-group-addon"><b>PRECIO</b></div>                       
                            <input type="text" class="form-control" id="precio" name="precio" onkeypress="return filterFloat(event,this);">         
                          </div>
                        </div>                                      
                    </div>                       
                </form>                          
            </div>
            <!-- End Modal Body -->
            <!-- Modal Footer -->
            <div class="modal-footer">                        
                <div class="panel panel-footer text-center"> 
                    <button type="submit" class="btn btn-success" form="insertarEquipo">GUARDAR</button>                  
                    <button type="button" class="btn btn-default"
                            id="cerrarMdl"
                            data-dismiss="modal">
                                Cancelar</button>
                </div>               
            </div>
        </div>
    </div>
</div>