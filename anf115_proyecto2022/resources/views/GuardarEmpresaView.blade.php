@extends('layouts.app')
    
@section('menu')
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('vendors/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SisCont_ANF-2022</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('vendors/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="#" class="d-block">Bienvenido Usuario</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <div>
            <a href="{{route('empresa_insert')}}" class="btn btn-primary">Agregar Empresa</a> 
        </div>
        </ul>
      </nav>  <!-- /.sidebar-menu -->
    </div>  <!-- /.sidebar -->
</aside>

@endsection

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