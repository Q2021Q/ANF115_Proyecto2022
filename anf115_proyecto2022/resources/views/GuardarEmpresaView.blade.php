<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestióon de archivos</title>
</head>
<body>

<form action="{{route('importar_balance')}}" method = "POST" enctype="multipart/form-data">
    {{csrf_field()}}
   
    <h1>Gestión de archivos</h1>

<h2>Seleccionar para mostrar inmediatamente</h2>
<p>Selecciona el archivo a mostrar</p>

<!-- <input type="file" id="archivo1" /> -->
<input type="file" name="archivo2" id="archivo2"  />
<h4>Contenido del archivo:</h4>
<pre id="contenido-archivo"></pre>

<!-- style="display: none" -->
    <!-- value="Cargar Balance" id="activar" -->
  <div id = "mostraContenido" >
          <input type="submit" >
    </div>
</form>

</body>
<script>



    /**
    * Importar y operar con .csv
    **/
   
    /**
     * Leer y mostrar contenido inmediatamente
    **/  
   //********************************************************************** */
    function mostrarContenido(contenido) {
        
    var archivoInput = document.getElementById('archivo2');
      var archivoRuta = archivoInput.value;
      console.log(archivoRuta);
        const elemento = document.getElementById('contenido-archivo');
        elemento.innerHTML = contenido;
        const link = document.getElementById('mostraContenido');
        for(let i = 0; i < 5; i++) {
        link.click();
    }
      }
//******************************************************************************** */

    function leerArchivo(e) {
      const archivo = e.target.files[0];
      if (!archivo) {
        return;
      }
      var archivoInput = document.getElementById('archivo2');
      var archivoRuta = archivoInput.value;
      console.log(archivoRuta);
      const lector = new FileReader();
      lector.onload = function(e) {
        const contenido = e.target.result;
        mostrarContenido(contenido);
      };
      lector.readAsText(archivo);
    }
//************************************************************ */
    document.querySelector('#archivo2')
      .addEventListener('change', leerArchivo, false);
//      
  </script>
</html>