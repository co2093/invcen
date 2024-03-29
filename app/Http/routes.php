<?php

if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

/*
 * LAS RUTAS SE HAN AGRUPADO DE ACUEERDO A LOS PRIVILEGIOS DE CADA USUARIO
 * DEPENDIENDO DE SU ROL
 * */


/*========================================================================================
 * Ruta para la pagina de login
 =========================================================================================*/
Route::get('/', function () { 
       return view('auth.login');
       //return \View::make('Auth.login');
   });

/*========================================================================================
 * ruta hacia home
 =========================================================================================*/

Route::get('home', 'HomeController@index')->name('home');

/*========================================================================================
 * rutas para login  y logout
 =========================================================================================*/
Route::get('login','UsersController@showLoginForm');
Route::get('logout','UsersController@logout');
Route::post('login','UsersController@authenticate');

/*========================================================================================
 * RUTAS PARA EL ADMINISTRADOR DEL SISTEMA
 =========================================================================================*/

Route::group(['middleware' => ['auth','admin_financiero','depto','admin_bodega','equipo']], function (){
    //Route::resource('usuario','UsersController');
    Route::get('usuario','UsersController@index')->name('usuario.index');
    Route::post('usuario','UsersController@store')->name('usuario.store');
    Route::get('usuario/create','UsersController@create')->name('usuario.create');
    Route::get('usuario/{usuario}','UsersController@show')->name('usuario.show');
    Route::delete('usuario/{usuario}','UsersController@destroy')->name('usuario.destroy');
    Route::get('register','UsersController@getRegister');
    Route::post('register','UsersController@postRegister');
    Route::get('usuario/create/{id}','UsersController@create')->name('usuario-departamento');



});

/*========================================================================================
 * RUTAS PARA TODOS LOS USUARIOS
 =========================================================================================*/

Route::group(['middleware'=>['auth']],function(){
    //ruta para los roles
    Route::resource('roles','RolesController');
    //rutas de usuarios q solo puede acceder el admin
    Route::patch('usuario/{usuario}','UsersController@update')->name('usuario.update');
    Route::get('usuario/{usuario}/edit','UsersController@edit')->name('usuario.edit');

    Route::get('user/{id}',['as'=>'usuario-eliminar','uses'=>'UsersController@mostrar']);
    Route::get('{id}/edit','UsersController@getEdit');

/*========================================================================================
* RUTAS PARA EL PLAN DE COMPRAS (Todos los usuarios)
=========================================================================================*/

    Route::get('plancompras','PlanComprasController@index')->name('plan.index');
    Route::get('plancompras/consultar/productos','PlanComprasController@consultarProductos')->name('plandecompras.productos');
    Route::post('plancompras/nuevo/producto', 'PlanComprasController@store')->name('plandecompras.store');
    Route::get('plancompras/delete/producto/{idProduct}', 'PlanComprasController@deleteProduct')->name('plandecompras.deleteProduct');
    Route::get('plancompras/edit/producto/{idProduct}', 'PlanComprasController@editProduct')->name('plandecompras.edit');
    Route::post('plancompras/update/producto', 'PlanComprasController@updateProduct')->name('plandecompras.update');
    Route::get('plancompras/historial', 'PlanComprasController@historial')->name('plandecompras.historial');
    Route::get('plancompras/solicitar/existencias/{idProduct}', 'PlanComprasController@solicitarExistencias')->name('plandecompras.solicitar');
    Route::get('plancompras/excel', 'PlanComprasController@exportExcel')->name('plandecompras.excel.descargar');
    Route::get('plancompras/pdf', 'PlanComprasController@exportPdf')->name('plandecompras.pdf.descargar');
    Route::get('plancompras/nuevo', 'PlanComprasController@agregarNuevo')->name('plandecompras.agregarNuevo');
    Route::get('plancompras/resumen/', 'PlanComprasController@resumen')->name('plandecompras.resumen');
    Route::get('plancompras/resumen/excel', 'PlanComprasController@resumenExcel')->name('plandecompras.resumen.excel');
    Route::get('plancompras/resumen/pdf', 'PlanComprasController@resumenPdf')->name('plandecompras.resumen.pdf');
    Route::get('plancompras/error', 'PlanComprasController@error')->name('plandecompras.error');
    Route::post('plancompras/confirmar', 'PlanComprasController@confirmar')->name('plandecompras.confirmar');
    Route::get('plancompras/{cotizacion}/','PlanComprasController@descargarArchivo')->name('pladecompras.descargar');
    Route::get('plancompras/delete/{cotizacion}/','PlanComprasController@deleteArchivo')->name('plandecompras.eliminar');

    Route::get('plandecompras/excel/historial', 'PlanComprasController@excelHistorial')->name('plandecompras.excel.historial');



});

/*========================================================================================
 * RUTAS PARA LA CREACIONDE USUARIOS (ADMINISTRADOR DE BODEGA Y ADMINISTRADOR DEL SISTEMA)
 =========================================================================================*/

Route::group(['middleware' => ['auth','admin_financiero','depto','equipo']], function (){
    Route::get('register','UsersController@getRegister');
    Route::post('register','UsersController@postRegister');
    Route::get('usuario/create/{id}','UsersController@create')->name('usuario-departamento');
});

/*========================================================================================
 * RUTAS PARA EL ADMINISTRADOR DE BODEGA
 =========================================================================================*/

Route::group(['middleware'=>['depto','admin_financiero','admin','equipo']], function (){


    //Ruta para analizar la oferta y la demanda
    Route::get('existencia/ofertademanda','ExistenciaController@ofertaDemanda')->name('oferta_demanda');

    //Rutas para el proveedor
    Route::get('proveedor/detail/{id}', 'Article\ProviderController@detail');
    Route::get('proveedor/productos/{id}','Article\ProviderController@productosList')->name('productos-list');
    Route:: resource('proveedor','Article\ProviderController');

    //Rutas para los departamentos
    Route::get('departamento/asignarusuario','Departamento\DepartmentController@asignarUsuario')->name('asignar-usuario');
    Route::resource('departamento', 'Departamento\DepartmentController');

    //rutas para especifico
    Route::resource('especifico','EspecificoController');
    Route::get('especifico/delete/{id}','EspecificoController@delete')->name('yes');

    //rutas para unidad de medida
    Route::resource('unidad','UnidadMedidaController');
    Route::get('unidad/delete/{id_unidad_medida}','UnidadMedidaController@delete')->name('delete_unidad');

    //rutas para articulo
    Route::resource('articulo','ArticuloController');
    Route::get('articulo/delete/{codigoArticulo}','ArticuloController@delete')->name('delete_articulo');

    //rutas para categoria
   // Route::resource('categoria', 'CategoriaController');
    //Route::get('categoria/delete/{id_categoria}', 'CategoriaController@delete')->name('delete_categoria');


    //rutas para ingreso
    Route::resource('ingreso','IngresoController');
    Route::get('ingreso/delete/{idIngreso}','IngresoController@delete')->name('delete_ingreso');
    Route::get('ingreso/addExistencia/{codProducto}','IngresoController@create')->name('addExistencia');
    Route::get('ingreso/detalle/{id}', 'IngresoController@detalle')->name('ingresodetalle');

    //Rutas para descargos
    Route::resource('descargo','DescargoController');

    //Rutas para las transacciones en general
    Route::resource('transaccion','TransaccionController');

    //Rutas para las existencias
    Route::resource('existencia','ExistenciaController');
    

    //habilitar que los usuarios de departamento envien requisiciones
    Route::get('habilitarEnvios',['as'=>'habilitar-envios','uses'=>'RequisicionController@HabilitarEnvio']);
    Route::get('gestinarEnvios/{id}',['as'=>'gestionar-envios','uses'=>'RequisicionController@gestionarEnvios']);

    //eliminar requisicion
    //Route::post('requisicion/{id}/eliminar',['as'=>'requisicion.destroy','uses'=>'RequisicionController@destroy']);

    //desechar la requisicion
    Route::get('requisicion/desechar/{id}',['as'=>'requisicion-desechar','uses'=>'RequisicionController@desechar']);

    //Ruta para asignar la cantidad a aprobar de la requisicion
    Route::patch('requisicion/detalle/{detalle}','DetalleRequisicionController@update')->name('requisicion.detalle.update');

    //Estas rutas son del controlador de requisiciones, aun no se han definido y no se usan
    Route::get('requisicion/detalle/create','DetalleRequisicionController@create')->name('requisicion.detalle.create');
    Route::delete('requisicion/detalle/{detalle}','DetalleRequisicionController@destroy')->name('requisicion.detalle.destroy');

    /*rutas para descargar reactivo*/
    Route::get('get/existencia/reactivos',[
        'as'=>'get.existencia.reactivos',
        'uses'=>'ArticuloController@getExistenciaReactivos'
    ]);

    Route::get('get/reactivos/asignados',[
        'as'=>'get.reactivos.asignados',
        'uses'=>'ArticuloController@getReactivosAsignados'
    ]);

    Route::get('articulo/editar/existencia/{idProduct}', 'ArticuloController@editarExistencia')->name('articulo.editar.existencia');
    Route::get('articulo/editar/precio/{idProduct}', 'ArticuloController@editarPrecio')->name('articulo.editar.precio');

    Route::post('articulo/editar/existencia/', 'ArticuloController@editE')->name('articulo.editar.e');
    Route::post('articulo/editar/precio/', 'ArticuloController@editP')->name('articulo.editar.p');

});


/*========================================================================================
 * RUTAS PARA EL ADMINISTRADOR DE DEPARTAMENTO
 =========================================================================================*/
Route::Group(['middleware'=>['admin','admin_financiero','admin_bodega','equipo']], function () {
    //Ruta para ver el listado de productos que se pueden solicitar
    Route::get('requisicion/productos', 'RequisicionController@listaCompra')->name('lista_compra');

    //Ruta para crear la requisicion
    Route::get('requisicion/crear', [
        'as' => 'requisicion-show',
        'uses' => 'RequisicionController@crear'
    ]);

    //agregar articulo a la requisicion
    Route::post('requisicion/add', 'RequisicionController@add')->name('add');

    //Ruta para confirmar envio de la requisicion
    Route::get('requisicion/enviar', [
        'as' => 'requisicion-confirmar',
        'uses' => 'RequisicionController@confirmarEnvio'
    ]);
    Route::get('requisicion/store','RequisicionController@store');

    //Ruta para confirmar desechar las requisiciones, se usa juntamente con el metodo trash
    Route::get('requisicion/vaciar', [
        'as' => 'requisicion-vaciar',
        'uses' => 'RequisicionController@vaciarConfirm'
    ]);

    //eliminar articulo de la requisicion
    Route::get('requisicion/delete/{cod}', [
        'as' => 'requisicion-delete',
        'uses' => 'RequisicionController@delete'
    ]);

    //eliminar la requisicion que se esta creando
    Route::get('requisicion/trash', [
        'as' => 'requisicion-trash',
        'uses' => 'RequisicionController@trash'
    ]);

    //actualizar cantidad en articulo de la requisicion
    //Route::get('requisicion/update/{cod}/{cantidad}','RequisicionController@update');

    //Ruta para ver la lista de productos y agregar
    Route::get('requisicion/detalle','DetalleRequisicionController@index')->name('requisicion.detalle.index');

    //Rutas para control de existencia
    Route::get('producto/controlexistencia','ControlArticuloController@index')->name('producto.controlexistencia');

    //Crear una entrega
    Route::get('producto/entrega/create','EntregaController@create')->name('producto.entrega.create');
    Route::post('producto/entrega', 'EntregaController@store')->name('producto.entrega.store');

    //Ver entrega
    Route::get('producto/entrega','EntregaController@index')->name('producto.entrega.index');
    Route::get('producto/entrega/{id}','EntregaController@edit')->name('producto.entrega.edit');
    Route::put('producto/entrega/{id}','EntregaController@update')->name('producto.entrega.update');
    Route::get('producto/entrega/details/{id}','EntregaController@show')->name('producto.entrega.details');




});

/*========================================================================================
 * RUTAS PARA EL ADMINISTRADOR FINANCIERO
 =========================================================================================*/

    Route::Group(['middleware'=>['admin','depto','admin_bodega','equipo']], function (){

        // Ruta para ver las solicitudes
        Route::get('requisicion/lista',[
            'as'=>'requisicion-financiero',
            'uses'=>'RequisicionController@financieroRequisiciones'
        ]);

        //Rutas para denegar requision
        Route::get('requisicion/denegar/{cod}',[
            'as'=>'requisicion.denegar',
            'uses'=>'RequisicionController@denegarConfirm'
        ]);

        Route::post('requisicion/denegado/{cod}',[
            'as'=>'requisicion.denegado',
            'uses'=>'RequisicionController@denegar'
        ]);

        //Ruta para solicitar que se vuelva a editar la requisicion
        Route::get('requisicion/volvereditar/{cod}',['as'=>'editar-confirm','uses'=>'RequisicionController@editarConfirm']);
        Route::post('requisicion/editar/{cod}',['as'=>'volver-editar','uses'=>'RequisicionController@volverEditar']);

       



    });

/*========================================================================================
 *  RUTAS PARA EL ADMINISTRADOR FINANCIERO Y EL ADMINISTRADOR DE BODEGAS
 =========================================================================================*/

Route::Group(['middleware'=>['admin','depto','equipo']], function (){
    //imprimir requisicion
    Route::get('requisicion/imprimir/{id}','DetalleRequisicionController@imprimir');

    //observaciones a la requisicion
    Route::get('requisicion/observacion/{id}',[
        'as'=>'requisicion-observacion',
        'uses'=>'DetalleRequisicionController@observacion'
    ]);

   //Ruta para aprobar la requisicion
    Route::put('requisicion/detalle/aprobar/{id}','DetalleRequisicionController@aprobar')->name('requisicion.detalle.aprobar');

    //Ver resumen de requisiciones
    Route::get('requisicion/resumen', 'RequisicionController@verResumen')->name('requisicion.resumen');

    //Descargar excel
    Route::get('plandecompras-excel', 'RequisicionController@exportExcel')->name('plandecompras.excel');

    //Descargar pdf
    Route::get('plandecompras-pdf', 'RequisicionController@exportPdf')->name('plandecompras.pdf');

    Route::get('requisicion/resumen', 'RequisicionController@verResumen')->name('requisicion.resumen');

    Route::get('reportes','ReporteController@index')->name('reportes');

        //Rutas para la generacion de reportes
    Route::get('existencias/reporte',['as'=>'existencias.reporte',
        function(){
            return view('Existencia.reportes');
        }]);

    Route::get('reportes/kardex',['as'=>'reportes.kardex','uses'=>'ReporteController@kardex']);
    Route::get('reportes/kardex/crear','ReporteController@kardexForm')->name('reporte_kardexform');

    Route::get('reportes/existencia',['as'=>'reportes.existencia','uses'=>'ReporteController@existencia']);
    Route::get('reportes/existencia/crear','ReporteController@existenciaForm')->name('reporte_existenciaform');


    Route::get('reportes/consolidadoexistencia',['as'=>'reportes.consolidadoexistencia','uses'=>'ReporteController@consolidadoExistencia']);
    Route::get('reportes/consolidadoexistencia/crear','ReporteController@consolidadoExistenciaForm')->name('reporte_consolidadoexistenciaform');

    Route::get('reportes/historialproducto/crear','ReporteController@historialProductoForm')->name('reporte_historialproductoform');
    Route::get('reportes/historialProducto',['as'=>'reportes.historialproducto','uses'=>'ReporteController@historialProducto']);

    Route::get('reportes/proveedores', 'ReporteController@proveedoresPdf')->name('reporte.proveedores.pdf');

    Route::get('reportes/existencia/excel/crear', 'ReporteController@existenciaExcelForm')->name('reporte.existencia.form.excel');
    Route::get('reportes/existencia/excel', 'ReporteController@existenciaExcel')->name('reportes.existencia.excel');






});

/*========================================================================================
 * RUTAS PARA EL ADMINISTRADOR FINANCIERO, DE BODEGA Y DEL DEPARTAMENTO
 =========================================================================================*/

Route::Group(['middleware'=>['admin','equipo']], function (){
    Route::get('requisicion/listar',['as'=>'requisicion-listar','uses'=>'RequisicionController@index']);
    Route::post('requisicion/detalle','DetalleRequisicionController@store')->name('requisicion.detalle.store');
    Route::get('requisicion/detalle/{detalle}/edit','DetalleRequisicionController@edit')->name('requisicion.detalle.edit');
    //Ruta para ver en detalle a la requisicion
    Route::get('requisicion/detalle/{detalle}','DetalleRequisicionController@show')->name('requisicion.detalle.show');
    Route::get('plan-indv-pdf/{detalle}','DetalleRequisicionController@reporteindvPlanPDF')->name('requisicion.detalle.pdf');
    Route::get('exportar/{id}','DetalleRequisicionController@reporteindvPlanEXCEL')->name('requisicion.detalle.excel');
});

/*========================================================================================
 * RUTAS PARA EL ADMINISTRADOR DE EQUIPO
 =========================================================================================*/

Route::Group(['pregix'=>'equipo','middleware'=>['admin','depto','admin_financiero','admin_bodega']], function (){
  
    /*ruta para tipos de equipos*/
    Route::get('tipos',[
        'as'=>'equipo.lista.tipos',
        'uses'=>'EquipoController@tiposDeEquipos'
    ]);

    Route::get('nuevo/tipo',[
        'as'=>'equipo.nuevo.tipo',
        'uses'=>'EquipoController@nuevoTipoGet'
    ]);

    Route::post('nuevo/tipo/guardar',[
        'as'=>'equipo.nuevo.tipo.guardar',
        'uses'=>'EquipoController@nuevoTipoPost'
    ]);

    Route::get('editar/tipo/{id}',[
        'as'=>'tipo.equipo.editar',
        'uses'=>'EquipoController@editarTipoEquipoGet'
    ]);

    Route::post('editar/tipo',[
        'as'=>'tipo.equipo.editar.post',
        'uses'=>'EquipoController@editarTipoEquipoPost'
    ]);

    Route::post('eliminar/tipo',[
        'as'=>'tipo.equipo.eliminar',
        'uses'=>'EquipoController@eliminarTipoEquipo'
    ]);

    /*ruta para equipos*/
    Route::get('lista',[
        'as'=>'equipo.lista',
        'uses'=>'EquipoController@lista'
    ]);

    Route::get('get/lista',[
        'as'=>'equipo.get.lista',
        'uses'=>'EquipoController@getListaDeEquipos'
    ]);

    Route::post('insertar',[
        'as'=>'equipo.insertar',
        'uses'=>'EquipoController@insertarEquipo'
    ]);

    Route::get('get/to/editar',[
        'as'=>'get.equipo.to.editar',
        'uses'=>'EquipoController@getEquipoToEditar'
    ]);

    Route::get('detalles/{idEquipo}',[
        'as'=>'equipo.detalles',
        'uses'=>'EquipoController@detallesDeEquipo'
    ]);

    Route::get('reporte',[
        'as'=>'equipo.reporte',
        'uses'=>'pdfController@reporteDeEquipos'
    ]);
    Route::get('resumen',[
        'as'=>'equipo.resumen',
        'uses'=>'EquipoController@resumenDeEquipos'
    ]);
    Route::post('eliminar',[
        'as'=>'equipo.eliminar',
        'uses'=>'EquipoController@eliminarEquipo'
    ]);
    Route::post('equipos/to/excel',[
        'as'=>'equipo.excel',
        'uses'=>'EquipoController@exportarAExcel'
    ]);
    /*rutas para subir archivos de equipos */
    Route::get('equipos/archivos',[
        'as'=>'equipo.archivos',
        'uses'=>'EquipoController@archivosIndex'
    ]);
    Route::post('equipo/archivos/subir',[
        'as'=>'equipo.subir.archivos',
        'uses'=>'EquipoController@subirArchivosM'
    ]);
    Route::get('archivos/m/datatable/{categoria}',[
        'as' => 'archivos.m.datatable',        
        'uses' => 'EquipoController@getDatatableM'
      ]);
    Route::get('/verDocumento/{urlDocumento}/{tipoArchivo}',[
        'as' => 'ver.documento',        
        'uses' => 'pdfController@pdfArchivosEquipos'
      ]);

    Route::post('archivo/eliminar',[
        'as' => 'archivo.equipo.eliminar',        
        'uses' => 'EquipoController@elminarArchivo'
      ]);
});



/*========================================================================================
 * RUTAS PARA EL ADMINISTRADOR DEL SISTEMA Y EL ADMINISTRADOR FINANCIERO
 =========================================================================================*/



Route::group(['middleware' => ['auth','depto','equipo']], function (){



    Route::post('plancompras/buscar/', 'PlanComprasController@buscar')->name('plandecompras.filter');
    Route::get('plancompras/pdf/{categoria}', 'PlanComprasController@pdfCategoria')->name('plandecompras.pdf.categoria');
    Route::get('plancompras/excel/{categoria}', 'PlanComprasController@excelCategoria')->name('plandecompras.excel.categoria');
    Route::get('plancompras/pdf/usuario/{usuario}', 'PlanComprasController@pdfUsuario')->name('plandecompras.pdf.usuario');
    Route::get('plancompras/excel/usuario/{usuario}', 'PlanComprasController@excelUsuario')->name('plandecompras.excel.usuario');

    Route::get('plandecompras/individual', 'PlanComprasController@individual')->name('plandecompras.individual');
    Route::get('plandecompras/pdf/individual', 'PlanComprasController@pdfIndividual')->name('plandecompras.individual.pdf');
    Route::get('plandecompras/excel/individual', 'PlanComprasController@excelIndividual')->name('plandecompras.individual.excel');
    Route::post('plandecompras/buscar/individual', 'PlanComprasController@buscarIndividual')->name('plandecompras.filter.individual');
    Route::post('plandecompras/buscar/individual/user', 'PlanComprasController@buscarIndividualUser')->name('plandecompras.filter.individual.user');


    Route::get('plandecompras/pdf/{categoria}', 'PlanComprasController@pdfCategoriaInd')->name('plandecompras.pdf.categoria.ind');
    Route::get('plandecompras/excel/{categoria}', 'PlanComprasController@excelCategoriaInd')->name('plandecompras.excel.categoria.ind');

    Route::post('plandecompras/finalizar/producto', 'PlanComprasController@finalizarCompra')->name('plandecompras.finalizarCompra');
    Route::get('plandecompras/aprobar/{idProduct}', 'PlanComprasController@aprobar')->name('plandecompras.aprobar');
    Route::get('plandecompras/aprobar/general/{a}/{b}/{c}/{d}/{e}', 'PlanComprasController@aprobarGeneral')->name('plandecompras.aprobar.general');
    Route::get('plandecompras/aprobar/confirmar/{a}/{b}/{c}/{d}/{e}', 'PlanComprasController@aprobarGeneralConfirmar')->name('plandecompras.aprobar.confirmar');
    Route::get('plandecompras/consultar/general/{a}', 'PlanComprasController@consultarGeneral')->name('plandecompras.consultar.general');




});

Route::group(['middleware' => ['auth','depto','equipo','admin_bodega']], function (){

    Route::get('plandecom/finalizar/', 'PlanComprasController@finalizar')->name('plandecompras.finalizar');
    Route::get('plandecom/finalizar/confirmar', 'PlanComprasController@finalizarconfirmado')->name('plandecompras.finalizar.confirmar');


    Route::get('plan/habilitar', 'RequisicionController@habilitarPeriodo')->name('plandecompras.habilitar');
    Route::post('habilitar/update', 'RequisicionController@editarEstado')->name('periodo.update');

    Route::get('plancompras/historial/general', 'PlanComprasController@historialGeneral')->name('plandecompras.historial.general');
    Route::get('plandecompras/excel/historial/general', 'PlanComprasController@excelHistorialGeneral')->name('plandecompras.excel.historial.general');




});  
    

    




















