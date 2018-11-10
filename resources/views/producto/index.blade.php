
@extends('layouts.app')
<link rel="stylesheet" href="{{asset("css/index_style.css")}}">
@section('style')
<style type="text/css">
.desabled {
    pointer-events: none;
}
</style>


@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <strong>Agregar Productos</strong>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form id="addProducto" class="" method="POST" action="">
                        <div class="form-group">
                            <label for="Nombre" class="col-md-12 col-form-label">Nombre</label>

                            <div class="col-md-12">
                                <input id="Nombre" type="text" class="form-control" name="Nombre" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Precio" class="col-md-12 col-form-label">Precio</label>

                            <div class="col-md-12">
                                <input id="Precio" type="text" class="form-control" name="Precio" value="" required autofocus>
                        </div>
                        </div>

                        <div class="form-group">
                            <label for="Cantidad" class="col-md-12 col-form-label">Cantidad</label>

                            <div class="col-md-12">
                                <input id="Cantidad" type="text" class="form-control" name="Cantidad" value="" required autofocus>
                        </div>
                        </div>

                        <div class="form-group">
                            <label for="Calificacion" class="col-md-12 col-form-label">Calificacion</label>

                            <div class="col-md-12">
                                <input id="Calificacion" type="text" class="form-control" name="Calificacion" value="" required autofocus>
                        </div>
                        </div>
                        

                        <div id="div_file" align="center">
                           <p id="texto"> Add Archivo</p> 
                        <input type="file" name="fichero" value="" id="fichero" class="hidden">
                        </div>


                         <br>
                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-3">
                                <button type="button" class="btn btn-primary btn-block desabled" id="agregarProducto">
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <strong>Lista de Productos</strong>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad </th>
                            <th>Calificacion</th>
                            <th >Imagen</th>
                            <th width="180" class="text-center">Action</th>
                        </tr>
                        <tbody id="tbody">
                            
                        </tbody>    
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Model -->
<form action="" method="POST" class="Producto-remove-record-model">
    <div id="remove-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Eliminar Producto</h4>
                    <button type="button" class="close remove-data-from-delete-form" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h4>Esta seguro que desea eliminar el producto?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light deleteMatchRecord">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Update Model -->
<form action="" method="POST" class="Producto-update-record-model form-horizontal">
    <div id="update-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content" style="overflow: hidden;">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Actualizar Producto</h4>
                    <button type="button" class="close update-data-from-delete-form" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="updateBody">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect update-data-from-delete-form" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success waves-effect waves-light updateProducto">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="js/imagenes.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://www.gstatic.com/firebasejs/5.5.6/firebase.js"></script>
<script>
// Initialize Firebase
var config = {   apiKey: "{{ config('services.firebase.apikey') }}",
    authDomain: "{{ config('services.firebase.authDomain') }}",
    databaseURL: "{{ config('services.firebase.databaseURL') }}",
    storageBucket: "{{ config('services.firebase.storageBucket') }}",
};
firebase.initializeApp(config);

var database = firebase.database();

var lastIndex = 0;
/*

// obtener elementos
var uploader=document.getElementById('uploader');
var fileButton=document.getElementById('fichero');

//vigilar seleccion archivo
fileButton.addEventListener('change',function(e){

//obtener archivo 
var file=e.target.files[0];

//crear un storage ref
var storageRef=firebase.storage().ref('fotos_productos/'+ file.name);

//Subir archivo
var task =storageRef.put(file);
 
 //Actualizar barra de progreso
 task.on('state_changed',
    function progress(snapshot){
        var percentaje=(snapshot.bytesTransferred /snapshot.totalBytes) *100;
        uploader.value=percentaje;
    },
    function error(err){

    },
    function complete(){

    })
});*/


var self = this;

var fichero;
var storageRef;
var imagenesFBRef;

var image_url='';

var downloadURL;

function inicializar(){
    fichero=document.getElementById("fichero");
    fichero.addEventListener("change",subirImagenAfirebase, false);
    storageRef=firebase.storage().ref();

    imagenesFBRef=firebase.database().ref().child("Establecimiento/Restaurante/Producto");

    mostrarImagenesDeFirebase()

}

function mostrarImagenesDeFirebase(){
    imagenesFBRef.on("value",function(snapshot){
      var datos=snapshot.val();
       var result="";
       for (var key in datos){
            result='<img width="200" class="img-thumbnail" src="'+datos[key].Url_Image+'"/>';
       }
            
        
        document.getElementById("imagenes").innerHTML=result;
        
    })

}

function subirImagenAfirebase(){
    var imagenASubir=fichero.files[0];
    var uploadTask=storageRef.child('ImagenesProducto/'+imagenASubir.name).put(imagenASubir);

uploadTask.on('state_changed',
    function (snapshot){
       
    },
    function (error){
        alert("hubo un error");

    },
    function (){
    downloadURL=uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
    console.log("File available at", downloadURL);
     self.image_url=downloadURL;
     console.log(self.image_url);
     document.getElementById().innerHTML=downloadURL;
     crearNodoEnBDFirebase(downloadURL);
        });
        
    });
}
function crearNodoEnBDFirebase(downloadURL){
   
        //imagenesFBRef.push({Url_Image: downloadURL});
}

// Get Data
firebase.database().ref('Establecimiento/Restaurante/Producto/').on('value', function(snapshot) {

    var value = snapshot.val();
    var htmls = []; 
    $.each(value, function(index, value){
        if(value) {
            htmls.push('<tr>\
                <td>'+ value.Nombre +'</td>\
                <td>'+ value.Cantidad +'</td>\
                <td>'+ value.Precio +'</td>\
                <td>'+ value.Calificacion +'</td>\
                <td>'+ value.Url_Image +'</td>\
                <td><a data-toggle="modal" data-target="#update-modal" class="btn btn-outline-success updateData" data-id="'+index+'">Update</a>\
                <a data-toggle="modal" data-target="#remove-modal" class="btn btn-outline-danger removeData" data-id="'+index+'">Delete</a></td>\
            </tr>');
        }       
        lastIndex = index;
    });
    $('#tbody').html(htmls);
    $("#agregarProducto").removeClass('desabled');
});


// Add Data
$('#agregarProducto').on('click', function(){

    var values = $("#addProducto").serializeArray();

    var Nombre = values[0].value;
    var Cantidad= values[1].value;
    var Precio  = values[2].value;
    var Calificacion=values[3].value;
     
    var Url_Image=self.image_url;
    

    firebase.database().ref('Establecimiento/Restaurante/Producto/' ).push({
        
        Nombre: Nombre,
        Cantidad: Cantidad,
        Precio: Precio,
        Calificacion:Calificacion,
        Url_Image:Url_Image,
    });

    // Reassign lastID value
    
    $("#addProducto input").val("");
});

// Update Data
var updateID = 0;
$('body').on('click', '.updateData', function() {
    updateID = $(this).attr('data-id');
    firebase.database().ref('Establecimiento/Restaurante/Producto/' + updateID).on('value', function(snapshot) {
        var values = snapshot.val();
        var updateData = '<div class="form-group">\
                <label for="Nombre" class="col-md-12 col-form-label">Nombre</label>\
                <div class="col-md-12">\
                    <input id="Nombre" type="text" class="form-control" name="Nombre" value="'+values.Nombre+'" required autofocus>\
                </div>\
            </div>\
            <div class="form-group">\
                <label for="Precio" class="col-md-12 col-form-label">Precio</label>\
                <div class="col-md-12">\
                    <input id="Precio" type="text" class="form-control" name="Precio" value="'+values.Precio+'" required autofocus>\
                </div>\
            </div>\
            <div class="form-group">\
                <label for="Cantidad" class="col-md-12 col-form-label">Cantidad</label>\
                <div class="col-md-12">\
                    <input id="Cantidad" type="text" class="form-control" name="Cantidad" value="'+values.Cantidad+'" required autofocus>\
                </div>\
            </div>\
            <div class="form-group">\
                <label for="Calificacion" class="col-md-12 col-form-label">Calificacion</label>\
                <div class="col-md-12">\
                    <input id="Calificacion" type="text" class="form-control" name="Calificacion" value="'+values.Calificacion+'" required autofocus>\
                </div>\
            </div>\
            <div class="form-group">\
                <label for="Url_Image" class="col-md-12 col-form-label">Url_Image</label>\
                <div class="col-md-12">\
                    <input id="Url_Image" type="text" class="form-control" name="Url_Image" value="'+values.Url_Image+'" required autofocus>\
                </div>\
            </div>';

            $('#updateBody').html(updateData);
    });
});

$('.updateProducto').on('click', function() {
    var values = $(".Producto-update-record-model").serializeArray();
    var postData = {
        Nombre : values[0].value,
        Precio : values[1].value,
        Cantidad : values[2].value,
        Calificacion : values[3].value,
        Url_Image : values[4].value,

    };

    var updates = {};
    updates['Establecimiento/Restaurante/Producto/' + updateID] = postData;

    firebase.database().ref().update(updates);

    $("#update-modal").modal('hide');
});


// Remove Data
$("body").on('click', '.removeData', function() {
    var id = $(this).attr('data-id');
    $('body').find('.Producto-remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
});

$('.deleteMatchRecord').on('click', function(){
    var values = $(".Producto-remove-record-model").serializeArray();
    var id = values[0].value;
    firebase.database().ref('Establecimiento/Restaurante/Producto/' + id).remove();
    $('body').find('.Producto-remove-record-model').find( "input" ).remove();
    $("#remove-modal").modal('hide');
});
$('.remove-data-from-delete-form').click(function() {
    $('body').find('.Producto-remove-record-model').find( "input" ).remove();
});
</script>   


@endsection


