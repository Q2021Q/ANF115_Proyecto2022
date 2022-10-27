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
     
        <input type="number" id="indicadorEstadoFinanciero" name="indicadorEstadoFinanciero" value="1" style="display: none">
  
    <div id = "mostraContenido" style="display: none">

    <label >Periodo Contable</label>
    <select name="periodoContable" id="periodoContable" required>
      @foreach ($arrayPeriodos as $periodo)
      <option value="{{$periodo->year}}">{{$periodo->year}}</option>
      @endforeach
    </select>

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


  if(window.history && history.pushState){ // check for history api support
	window.addEventListener('load', function(){
		document.getElementById("cargaFile").reset();
	}, false);
}
//******************************************************************************** */
</script>

</html>