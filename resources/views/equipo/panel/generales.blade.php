<div class="tab-pane fade in active" id="panel-generales">
	<div class="panel-body">
		<div class="the-box full no-border">
			<div class="container-fluid">
				<div class="row">         
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>TIPO DE EQUIPO</b></div>                       
              <input type="text" class="form-control"  value="{{$equipo->tipo['nombre_tipo_equipo']}}" disabled="true">         
            </div>
          </div> 
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>NÚMERO INVENTARIO</b></div>                       
              <input type="text" class="form-control"  value="{{$equipo->numero_inventario}}" disabled="true">         
            </div>
          </div> 
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>ESPECIFICO</b></div>                       
              <input type="text" class="form-control"  value="{{$equipo->especifico}}" disabled="true">         
            </div>
          </div>     
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>NÚMERO DE SERIE</b></div>                       
              <input type="text" class="form-control"  value="{{$equipo->numero_serie}}" disabled="true">         
            </div>
          </div>
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>MARCA</b></div>                       
              <input type="text" class="form-control"  value="{{$equipo->marca}}" disabled="true">         
            </div>
          </div>
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>MODELO</b></div>                       
              <input type="text" class="form-control" value="{{$equipo->modelo}}" disabled="true">         
            </div>
          </div>
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>DESCRIPCIÓN</b></div>                       
              <input type="text" class="form-control"  value="{{$equipo->descripcion}}" disabled="true">         
            </div>
          </div>
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>OBSERVACIÓN</b></div> 
              <textarea class="form-control" disabled="true">{{$equipo->observacion}}</textarea>          
            </div>
          </div>  
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>ESTADO</b></div>            
              <input type="text" class="form-control"  value="{{$equipo->status['estado']}}" disabled="true">   
            </div>
          </div>                      
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>RESPONSABLE</b></div>                       
              <input type="text" class="form-control" value="{{$equipo->responsable}}" disabled="true">         
            </div>
          </div>
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>UBICACIÓN</b></div>                       
              <input type="text" class="form-control" value="{{$equipo->ubicacion}}" disabled="true">         
            </div>
          </div>
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>FECHA ADQUISICIÓN</b></div>                       
              <input type="text" class="form-control"  value="{{$equipo->fecha_adquisicion}}" disabled="true">         
            </div>
          </div>
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon"><b>PROCEDENCIA</b></div>                       
              <input type="text" class="form-control" value="{{$equipo->procedencia}}" disabled="true">         
            </div>
          </div> 
          @if($equipo->procedencia=='compra')
          <div class="form-group col-md-12" id="div_precio">
            <div class="input-group">
              <div class="input-group-addon"><b>PRECIO</b></div>                       
              <input type="text" class="form-control" value="{{$equipo->precio}}" disabled="true">         
            </div>
          </div> 
          @endif                   
        </div>
			</div>		
		</div>
	</div>
</div>