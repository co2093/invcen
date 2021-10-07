<div class="tab-pane fade" id="panel-m4">
	<div class="panel-body">
		<div class="the-box full no-border">
			<div class="container-fluid">
				<div class="panel panel-success">    
            <div class="panel-heading" >
                <h3 class="panel-title">
                    Subir archivos M4
                </h3>
            </div>          
            <div class="panel-body">
            <form method="POST" action="{{route('equipo.subir.archivos')}}" enctype="multipart/form-data" id="frm_subir_archivos_m4">              
              <div class="form-group">
                          <div class="row">
                            <div class="col-sm-12 col-md-12">
                             <div class="input-group">
                               <div class="input-group-addon"><b>Documentos a subir...</b></div>
                               <input id="fileM4" name="fileM4[]"  type="file" multiple class="file-loading" required> 
                              
                               </div>
                             <div id="errorBlockNew" class="help-block"></div>
                            </div>
                          </div>
                      </div>                                 
                      <div class="modal-footer" >
                        <div align="center">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
                        <input type="hidden" name="categoria" value="M4">
                        <button type="button" class="btn btn-success btn-perspective" onclick="return submitFormulariosArchivos('frm_subir_archivos_m4','table_m4')"><i class="fa fa-paper-plane"></i> Enviar</button>  
                       </div>
                    </div>                     
            </form>
          </div>                                                   
                      
        </div>
        <div class="panel panel-success">
    
            <div class="panel-heading" >
                <h3 class="panel-title">
                    B&uacute;squeda de archivos M4
                </h3>
            </div>    
            <div id="collapse-filter" class="">
                <div class="panel-body">                    
                    <form role="form" id="search-form-m4">
                      <div class="row">                       
                        <div class="form-group col-xs-12 col-md-6 col-lg-6">
                          <div class="input-group">
                              <div class="input-group-addon"><b>TÍTULO</b></div>
                              <input type="text" id="ftitulo4" name="ftitulo4" class="form-control" autocomplete="off">
                          </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon"><b>FECHA SUBIDA</b></div>
                                <input type="text" id="ffecha4" name="ffecha4" class="form-control datepicker2" autocomplete="off" data-date-format="dd-mm-yyyy">
                            </div>
                        </div>                
                      </div>                                                   
                      <div class="modal-footer" >
                        <div align="center">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
                        <button type="submit" class="btn btn-success btn-perspective" id="btnConsultar"><i class="fa fa-search"></i> Buscar</button>
                       </div>
                      </div>                   
                    </form>                  
                </div><!-- /.panel-body -->
            </div><!-- /.collapse in -->
        </div>
        <div class="table-responsive">         
          <table class="table table-hover table-striped table-bordered table-condensed" width="99.7%" id="table_m4">
            <thead>
              <tr>
                <th class="col-md-1">No</th>                                
                <th class="col-md-8">TÍTULO</th>
                <th class="col-md-2">FECHA DE SUBIDA</th>
                <th class="col-md-1">-</th>
              </tr>
            </thead>
            <tbody>
             
            </tbody>
          </table>             
        </div>
			</div>		
		</div>
	</div>
</div>