<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{route('importar_balance')}}" method = "POST" enctype="multipart/form-data">
    {{csrf_field()}}
    <h2>Importar Balance General para la xxyy</h2>
  <p>Selecciona el archivo a gestionar</p>
        <input type="file" name="archivo2" id="archivo2" onchange="return validarExt()" />
        <br>
        <br>
        
       
    <div id="tablares" align="center"></div>



    <div id = "mostraContenido" style="display: none">
          <input type="submit" value="Cargar Balance" >
    </div>
    </form>
</body>

<script>



function validarExt()
{
    var archivoInput = document.getElementById('archivo2');
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.csv)$/i;
    if(!extPermitidas.exec(archivoRuta)){
        alert('Extencion de archivo incorrecta');
        archivoInput.value = '';
        document.getElementById('mostraContenido').style.display = 'none';
        document.getElementById('tablares').style.display = 'none';
        return false;
    }
    else
    {
      document.getElementById('mostraContenido').style.display = ''; 
      document.getElementById('tablares').style.display = '';
      return true;
    }
}


    /**
    * Importar y operar con .csv
    **/
    function crearTabla(data) {
      const todasFilas = data.split(/\r?\n|\r/);
      let tabla = '<table>';
      for (let fila = 0; fila < todasFilas.length; fila++) {
        if (fila === 0) {
          tabla += '<thead>';
          tabla += '<tr>';
        } else {
          tabla += '<tr>';
        }
        const celdasFila = todasFilas[fila].split(';');
        for (let rowCell = 0; rowCell < celdasFila.length; rowCell++) {
          if (fila === 0) {
            tabla += '<th>';
            tabla += celdasFila[rowCell];
            tabla += '</th>';
          } else {
            tabla += '<td>';
            // if (rowCell === 3) {
            //   tabla += '<img src="'+celdasFila[rowCell]+'">';
            // } else {
            //   tabla += celdasFila[rowCell];
            // }
            tabla += celdasFila[rowCell];
            tabla += '</td>';
          }
        }
        if (fila === 0) {
          tabla += '</tr>';
          tabla += '</thead>';
          tabla += '<tbody>';
        } else {
          tabla += '</tr>';
        }
      } 
      tabla += '</tbody>';
      tabla += '</table>';
      document.querySelector('#tablares').innerHTML = tabla;
    }

    function leerArchivo2(evt) {
      let file = evt.target.files[0];
      let reader = new FileReader();
      reader.onload = (e) => {
        // Cuando el archivo se terminó de cargar
        if(validarExt())
           crearTabla(e.target.result)
      };
      // Leemos el contenido del archivo seleccionado
      reader.readAsText(file);
    }
    document.querySelector('#archivo2')
      .addEventListener('change', leerArchivo2, false);

    /**
     * Leer y mostrar contenido inmediatamente
    **/  
   
    function leerArchivo(e) {
      const archivo = e.target.files[0];
      if (!archivo) {
        return;
      }
      const lector = new FileReader();
      lector.onload = function(e) {
        const contenido = e.target.result;
        mostrarContenido(contenido);
      };
      lector.readAsText(archivo);
    }
  
  </script>

</html>