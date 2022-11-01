@extends('layouts.app')
    
@section('content')
<head>
    <title>Insert Empresa</title>
</head>
<body>

    <form action="{{route('guardar_empresa_e')}}" method = "POST" enctype="multipart/form-data" id="cargaFile">
    {{csrf_field()}}


    <h2>Agregar Nueva Empresa</h2>
    <p>Seleccione el archivo</p>
        
    
        <div>
          <label for="">Codigo Empresa</label>
          <input type="text" id="idEmpresa" name="idEmpresa" required>
          <br> 
          <br> 
          <label for="">Nombre Empresa</label>
          <input type="text" id="nomEmpresa" name="nomEmpresa" required>
          <br> 
          <br> 
          <label >Sector de la Empresa</label>
          <select name="rubroEmpresa" id="rubroEmpresa" required>
            @foreach ($rubroEmpresa as $rubro)
            <option value="{{$rubro->IDRUBROEMPRESA}}">{{$rubro->NOMBRERUBROEMPRESA}}</option>
            @endforeach
          </select>
          <br> 
          <br> 
          <input type="file" name="imagen" id="imagen" onchange="return validarExt()" />
        <br> 
        <br> 
        </div>
  
    <div id = "mostraContenido" style="display: none">
      <input type="submit" value="Guardar Empresa" >
      <img src="{{ asset('imagenes/cargaImagen.png') }}" alt="" class="imgPerfil" width="200" height="200">
    </div>              <!--  Ancho -->
    </form>
</body>

<script>
 

 //Esta funcion valida la extencion del archivo
function validarExt()
{
    var archivoInput = document.getElementById('imagen');
   
    var archivoRuta = archivoInput.value;
    console.log(archivoRuta);
    var extPermitidas = /(.jpg|.jpeg|.png|.gif|.JPG|.JPEG|.PNG|.GIF)$/i;
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
@endsection