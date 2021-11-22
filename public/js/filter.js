$(document).ready(function(){
    



    fetch_data();



    
    function fetch_data(especificos = '')
    {

    console.log($('#category_filter').val());

    $('#TablaArticulo').DataTable({
        "lengthChange": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url":"/articulo",
            "data": "{especificos:especificos}"
        },

    "columns":[
    {
        "data": "titulo_especifico",
        "name": "titulo_especifico",
        
    },
    {
        "data": "codigo_articulo",
        "name": "codigo_articulo"
    },
    {
        "data": "nombre_articulo",
        "name": "nombre_articulo",
    },
    {
        "data": 'nombre_unidadmedida',
        "name":'nombre_unidadmedida'
    }]

  });

}

$('#category_filter').change(function(){
    var category_filter = $('#category_filter').val();

    $('#TablaArticulo').DataTable().destroy();

    fetch_data(category_filter);
});

});
