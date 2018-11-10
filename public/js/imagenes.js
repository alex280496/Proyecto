window.onload=inicializar;
var fichero;
var storageRef;
var imagenesFBRef;

function inicializar(){
	fichero=document.getElementById("fichero");
	fichero.addEventListener("change",subirImagenAfirebase, false);
	storageRef=firebase.storage().ref();

	imagenesFBRef=firebase.database().ref().child("Establecimiento/Restaurante/Producto");

	mostrarImagenesDeFirebase()

}

function mostrarImagenesDeFirebase(){

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
    var downloadURL=uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
    console.log("File available at", downloadURL);

     crearNodoEnBDFirebase(downloadURL);
  		});
    	
    });
}
function crearNodoEnBDFirebase(downloadURL){
	//imagenesFBRef.push({Url_Image: downloadURL});

}