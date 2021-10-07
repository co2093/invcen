@extends('layouts.template')
@section('css')
	{!! Html::style('plugins/bootstrap-fileinput/css/fileinput.min.css') !!}
	<link rel="stylesheet" href=" {{ asset('bootstrap/css/jquery-ui.min.css') }}">
	<style type="text/css">
		#panelArchivos{
			min-height: 500px;
		}
	</style>
@endsection

@section('content')
<div class="panel panel-primary" id="panelArchivos">	
	<div class="panel-heading">
    	<h3 class="panel-title">Archivos de equipos</h3>
	</div>
	<div class="panel-body">
	    <div class="row">
	      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">     		  
	    		<div class="panel with-nav-tabs panel-success">
	          <div class="panel-heading">
	            <ul class="nav nav-tabs">
	              <li class="active"><a href="#panel-m1" data-toggle="tab">M1</a></li>
	              <li><a href="#panel-m2" data-toggle="tab">M2</a></li> 
	              <li><a href="#panel-m3" data-toggle="tab">M3</a></li>
	              <li><a href="#panel-m4" data-toggle="tab">M4</a></li> 
	              <li><a href="#panel-m5" data-toggle="tab">M5</a></li>                 
	            </ul> 
	          </div>
	          <div id="panel-collapse-1" class="collapse in">
	            <div class="panel-body">
	              <div class="tab-content">
	                  	{{-- panel m1 --}}
		                  @include('equipo.panel.m1')
		                {{-- /panel m2 --}}

		                {{-- panel m2 --}}
		                  @include('equipo.panel.m2')
		                {{-- /panel m2--}}

		                {{-- panel m3 --}}
		                  @include('equipo.panel.m3')
		                {{-- /panel m3--}}

		                {{-- panel m4 --}}
		                  @include('equipo.panel.m4')
		                {{-- /panel m4--}}

		                {{-- panel m5 --}}
		                  @include('equipo.panel.m5')
		                {{-- /panel m5--}}            

	              </div><!-- /.tab-content -->
	            </div><!-- /.panel-body -->           
	          </div><!-- /.collapse in -->
	        </div>
	        <div class="text-center">
	         
	        </div>
	      </div>      
	    </div>
	</div>
</div>

@endsection
@section('script')
	{!! Html::script('plugins/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js') !!}
	{!! Html::script('plugins/bootstrap-fileinput/js/fileinput.min.js') !!}
	{!! Html::script('plugins/bootstrap-fileinput/js/fileinput_locale_es.js') !!}
	{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!} 
	<script src="{{asset('bootstrap/js/jquery-ui.min.js')}}"></script>
	
<script type="text/javascript">
	var tableM1;
	var tableM2;
	var tableM3;
	var tableM4;
	var tableM5;
        $(document).ready(function() {

        	$(".datepicker2").datepicker({		        
		        dateFormat: "yy-mm-dd"
		    });

            $("#fileM1" ).fileinput({
		      language: "es",
		      overwriteInitial: true,
		      browseLabel: 'Seleccionar archivos',
		      removeLabel: '',
			    browseIcon: '<i class="fa fa-folder-open"></i>',
		      removeIcon: '<i class="fa fa-times"></i>',
		      removeTitle: 'Cancelar o resetear cambios',
		      showUpload: false,
		      showRemove: true,
		      MaxFileCount : 10,
		      dropZoneEnabled: true,
		       layoutTemplates: {main2: '{preview} {remove} {browse}'},
		       msgErrorClass: 'alert alert-block alert-danger',
		    });

		    $("#fileM2" ).fileinput({
		      language: "es",
		      overwriteInitial: true,
		      browseLabel: 'Subir archivos',
		      removeLabel: '',
			    browseIcon: '<i class="fa fa-folder-open"></i>',
		      removeIcon: '<i class="fa fa-times"></i>',
		      removeTitle: 'Cancelar o resetear cambios',
		      showUpload: false,
		      showRemove: true,
		      MaxFileCount : 10,
		      dropZoneEnabled: true,
		       layoutTemplates: {main2: '{preview} {remove} {browse}'},
		       msgErrorClass: 'alert alert-block alert-danger',
		    });

		    $("#fileM3" ).fileinput({
		      language: "es",
		      overwriteInitial: true,
		      browseLabel: 'Subir archivos',
		      removeLabel: '',
			    browseIcon: '<i class="fa fa-folder-open"></i>',
		      removeIcon: '<i class="fa fa-times"></i>',
		      removeTitle: 'Cancelar o resetear cambios',
		      showUpload: false,
		      showRemove: true,
		      MaxFileCount : 10,
		      dropZoneEnabled: true,
		       layoutTemplates: {main2: '{preview} {remove} {browse}'},
		       msgErrorClass: 'alert alert-block alert-danger',
		    });

		    $("#fileM4" ).fileinput({
		      language: "es",
		      overwriteInitial: true,
		      browseLabel: 'Subir archivos',
		      removeLabel: '',
			    browseIcon: '<i class="fa fa-folder-open"></i>',
		      removeIcon: '<i class="fa fa-times"></i>',
		      removeTitle: 'Cancelar o resetear cambios',
		      showUpload: false,
		      showRemove: true,
		      MaxFileCount : 10,
		      dropZoneEnabled: true,
		       layoutTemplates: {main2: '{preview} {remove} {browse}'},
		       msgErrorClass: 'alert alert-block alert-danger',
		    });

		    $("#fileM5" ).fileinput({
		      language: "es",
		      overwriteInitial: true,
		      browseLabel: 'Subir archivos',
		      removeLabel: '',
			    browseIcon: '<i class="fa fa-folder-open"></i>',
		      removeIcon: '<i class="fa fa-times"></i>',
		      removeTitle: 'Cancelar o resetear cambios',
		      showUpload: false,
		      showRemove: true,
		      MaxFileCount : 10,
		      dropZoneEnabled: true,
		       layoutTemplates: {main2: '{preview} {remove} {browse}'},
		       msgErrorClass: 'alert alert-block alert-danger',
		    });
		
			
			/*datatable M1*/
	        tableM1 = $('#table_m1').DataTable({
		    filter:false,
		    processing: true,
		    serverSide: true,
		    lengthChange: false,
		    ajax: {processing: true,
		        url: "{{ route('archivos.m.datatable',['categoria'=>'M1']) }}",
		        data: function (d) {
		            d.ftitulo = $('#ftitulo1').val();
		            d.ffecha = $('#ffecha1').val();		            	                            
		        }		          
		    },
		    columns: [        	 
		        {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable:false},
		        {data: 'titulo_archivo', name: 'titulo_archivo'},
		        {data: 'fecha_subida', name: 'fecha_subida'},
		        {data: 'descargar', name: 'descargar',orderable:false}		                    
		    ],		    
		    order: [[2, 'asc']],
		    language: {
		        "sProcessing": '<div class=\"dlgwait\"></div>',
		          //"url": "{{ asset('plugins/datatable/lang/es.json') }}"	          
		          
		    },
		    columnDefs: [
		        {                
		            "visible": false             
		        }
		    ]    
		  	}); //end Datatable
		  	$('#search-form-m1').on('submit', function(e) { 

		       tableM1.draw();
		        e.preventDefault();
		       //$("#colp").attr("class", "block-collapse collapsed");
		       // $("#collapse-filter").attr("class", "collapse");
		    });
		    tableM1.rows().remove();

		    tableM2 = $('#table_m2').DataTable({
		    filter:false,
		    processing: true,
		    serverSide: true,
		    lengthChange: false,
		    ajax: {processing: true,
		        url: "{{ route('archivos.m.datatable',['categoria'=>'M2']) }}",
		        data: function (d) {
		            d.ftitulo = $('#ftitulo2').val();
		            d.ffecha = $('#ffecha2').val();		            	                            
		        }		          
		    },
		    columns: [        	 
		        {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable:false},
		        {data: 'titulo_archivo', name: 'titulo_archivo'},
		        {data: 'fecha_subida', name: 'fecha_subida'},
		        {data: 'descargar', name: 'descargar',orderable:false}		                    
		    ],
		    order: [[2, 'asc']],
		    language: {
		        "sProcessing": '<div class=\"dlgwait\"></div>',
		          //"url": "{{ asset('plugins/datatable/lang/es.json') }}"	          
		          
		    },
		    columnDefs: [
		        {                
		            "visible": false             
		        }
		    ]    
		  	}); //end Datatable
		  	$('#search-form-m2').on('submit', function(e) { 

		       tableM2.draw();
		        e.preventDefault();
		       //$("#colp").attr("class", "block-collapse collapsed");
		       // $("#collapse-filter").attr("class", "collapse");
		    });
		    tableM2.rows().remove();

		    tableM3 = $('#table_m3').DataTable({
		    filter:false,
		    processing: true,
		    serverSide: true,
		    lengthChange: false,
		    ajax: {processing: true,
		        url: "{{ route('archivos.m.datatable',['categoria'=>'M3']) }}",
		        data: function (d) {
		            d.ftitulo = $('#ftitulo3').val();
		            d.ffecha = $('#ffecha3').val();		            	                            
		        }		          
		    },
		    columns: [        	 
		        {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable:false},
		        {data: 'titulo_archivo', name: 'titulo_archivo'},
		        {data: 'fecha_subida', name: 'fecha_subida'},
		        {data: 'descargar', name: 'descargar',orderable:false}		                    
		    ],
		    order: [[2, 'asc']],
		    language: {
		        "sProcessing": '<div class=\"dlgwait\"></div>',
		          //"url": "{{ asset('plugins/datatable/lang/es.json') }}"	          
		          
		    },
		    columnDefs: [
		        {                
		            "visible": false             
		        }
		    ]    
		  	}); //end Datatable
		  	$('#search-form-m3').on('submit', function(e) { 

		       tableM3.draw();
		        e.preventDefault();
		       //$("#colp").attr("class", "block-collapse collapsed");
		       // $("#collapse-filter").attr("class", "collapse");
		    });
		    tableM3.rows().remove(); /*fin datatables m3*/

		    tableM4 = $('#table_m4').DataTable({
		    filter:false,
		    processing: true,
		    serverSide: true,
		    lengthChange: false,
		    ajax: {processing: true,
		        url: "{{ route('archivos.m.datatable',['categoria'=>'M4']) }}",
		        data: function (d) {
		            d.ftitulo = $('#ftitulo4').val();
		            d.ffecha = $('#ffecha4').val();		            	                            
		        }		          
		    },
		    columns: [        	 
		        {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable:false},
		        {data: 'titulo_archivo', name: 'titulo_archivo'},
		        {data: 'fecha_subida', name: 'fecha_subida'},
		        {data: 'descargar', name: 'descargar',orderable:false}		                    
		    ],
		    order: [[2, 'asc']],
		    language: {
		        "sProcessing": '<div class=\"dlgwait\"></div>',
		          //"url": "{{ asset('plugins/datatable/lang/es.json') }}"	          
		          
		    },
		    columnDefs: [
		        {                
		            "visible": false             
		        }
		    ]    
		  	}); //end Datatable
		  	$('#search-form-m4').on('submit', function(e) { 

		       tableM4.draw();
		        e.preventDefault();
		       //$("#colp").attr("class", "block-collapse collapsed");
		       // $("#collapse-filter").attr("class", "collapse");
		    });
		    tableM4.rows().remove(); /*fin datatables m4*/

		    tableM5 = $('#table_m5').DataTable({
		    filter:false,
		    processing: true,
		    serverSide: true,
		    lengthChange: false,
		    ajax: {processing: true,
		        url: "{{ route('archivos.m.datatable',['categoria'=>'M5']) }}",
		        data: function (d) {
		            d.ftitulo = $('#ftitulo5').val();
		            d.ffecha = $('#ffecha5').val();		            	                            
		        }		          
		    },
		    columns: [        	 
		        {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable:false},
		        {data: 'titulo_archivo', name: 'titulo_archivo'},
		        {data: 'fecha_subida', name: 'fecha_subida'},
		        {data: 'descargar', name: 'descargar',orderable:false}		                    
		    ],
		    order: [[2, 'asc']],
		    language: {
		        "sProcessing": '<div class=\"dlgwait\"></div>',
		          //"url": "{{ asset('plugins/datatable/lang/es.json') }}"	          
		          
		    },
		    columnDefs: [
		        {                
		            "visible": false             
		        }
		    ]    
		  	}); //end Datatable
		  	$('#search-form-m5').on('submit', function(e) { 

		       tableM5.draw();
		        e.preventDefault();
		       //$("#colp").attr("class", "block-collapse collapsed");
		       // $("#collapse-filter").attr("class", "collapse");
		    });
		    tableM5.rows().remove();
        });

function submitFormulariosArchivos(idFormulario,tableM){
	$("#"+idFormulario).submit(function(e){
    var formObj = $(this);
    var formURL = formObj.attr("action");
  	var formData = new FormData(this);
    $.ajax({
      data: formData,
      url: formURL,
      type: 'post',
      mimeType:"multipart/form-data",
        contentType: false,
          cache: false,
          processData:false,
      beforeSend: function() {
        $('body').modalmanager('loading');
      },
          success:  function (response){
            $('body').modalmanager('loading');
            if(isJson(response))
            {
	            /*alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Archivos almacenados exitosamente!</p></strong>",function(){
	                    
	            });*/
          		var obj =  JSON.parse(response);
                document.getElementById(idFormulario).reset(); 
                //tableM.ajax.reload();	
                if(tableM=='table_m1')
                {
                	tableM1.ajax.reload();
                }
                else if(tableM=='table_m2')   
                {
                	tableM2.ajax.reload();
                } 
                else if(tableM=='table_m3')   
                {
                	tableM3.ajax.reload();
                } 
                else if(tableM=='table_m4')   
                {
                	tableM4.ajax.reload();
                } 
                else if(tableM=='table_m5')   
                {
                	tableM5.ajax.reload();
                }
                /*se limpian los input*/ 
                $('#fileM1').val(''); 
                $('#fileM2').val('');
                $('#fileM3').val('');
                $('#fileM4').val('');
                $('#fileM5').val(''); 
                alertify.success("<strong><p class='text-warning text-justify'>¡Archivos almacenados exitosamente!</p></strong>");
            }else{
              /*alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>");*/
              alertify.warning("<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>");
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {        
        	alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la información!</p></strong>");
            console.log("Error en peticion AJAX!");  
      		/*se limpian los input por si acaso*/ 
            $('#fileM1').val(''); 
            $('#fileM2').val('');
            $('#fileM3').val('');
            $('#fileM4').val('');
            $('#fileM5').val('');
            $('body').modalmanager('loading');
          }
    });
    $("#"+idFormulario).preventDefault(); //Prevent Default action. 

    }).submit();

}

function eliminarArchivo(idAr,tableM){
  alertify.confirm('Mensaje de sistema','¿Esta seguro que desea elimiar este archivo?',function(){
    $.ajax({
      data : {_token:'{{ csrf_token() }}',txtArchivo: idAr, catego:tableM},
      url: "{{ route('archivo.equipo.eliminar') }}",
      type: "post",
      cache: false,
      mimeType:"multipart/form-data",
       beforeSend: function() {
                $('body').modalmanager('loading');
              },
          success:  function (response){
            $('body').modalmanager('loading');
                    if(isJson(response)){
                      alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Registro eliminado exitosamente!</p></strong>",function(){
                        var obj =  JSON.parse(response);
                        if(tableM=='M1')
	                    {
	                    	tableM1.ajax.reload();
	                    }
	                    else if(tableM=='M2')   
	                    {
	                    	tableM2.ajax.reload();
	                    } 
	                    else if(tableM=='M3')   
	                    {
	                    	tableM3.ajax.reload();
	                    }
	                    else if(tableM=='M4')   
	                    {
	                    	tableM4.ajax.reload();
	                    }
	                    else if(tableM=='M5')   
	                    {
	                    	tableM5.ajax.reload();
	                    }
                      });
                      
                    }else{
                      alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
                    }
                  },
          error: function(jqXHR, textStatus, errorThrown) {
        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo eliminar el archivo!</p></strong>");
              console.log("Error en peticion AJAX!");  
          }
         });
      },null).set('labels', {ok:'SI', cancel:'NO'}); 
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
</script>
@endsection