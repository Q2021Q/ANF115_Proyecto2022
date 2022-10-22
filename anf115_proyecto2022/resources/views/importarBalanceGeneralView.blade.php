<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga de archivos</title>
</head>
<body>
    <form action="{{route('importar_balance')}}" method = "POST" enctype="multipart/form-data" id="cargaFile">
    {{csrf_field()}}
    <h2>Importar Balance General para xxyy</h2>
    <p>Seleccione el archivo</p>
        <input type="file" name="balance" id="balance" onchange="return validarExt()" />
        <br>
        <br>        
      
    <div id = "mostraContenido" style="display: none">
      <input type="submit" value="Cargar Balance" >
      <img src="{{ asset('imagenes/csv.jpg') }}" alt="" class="imgPerfil" width="200" height="200">
    </div>              <!--  Ancho -->
    </form>
</body>

<script>
 

 //Esta funcion valida la extencion del archivo
function validarExt()
{
    var archivoInput = document.getElementById('balance');
   
    var archivoRuta = archivoInput.value;
    console.log(archivoRuta);
    var extPermitidas = /(.csv)$/i;
    if(!extPermitidas.exec(archivoRuta)){
        alert('Extencion de archivo incorrecta');
        archivoInput.value = '';
        document.getElementById('mostraContenido').style.display = 'none';
        return false;
    }
    else
    {
      document.getElementById('mostraContenido').style.display = ''; 
      return true;
    }
}

//*************************************************************************************** */
//COMPATIBLE CON CHROME
// Esta seccion de codigo es para limpiar el formulario al retroceder en el navegador
// window.onbeforeunload = function(e) {
//  window.location.reload();
// };

// window.addEventListener("popstate", detectHistory);

// function detectHistory(){
// console.log("bien")
// }
  if(window.history && history.pushState){ // check for history api support
	window.addEventListener('load', function(){
		document.getElementById("cargaFile").reset();
	}, false);
}
//******************************************************************************** */
</script>

</html>