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
          <a href="#" class="d-block">Solo William trabaja</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <div>
            <!-- <a href="{{route('empresa_insert')}}" class="btn btn-primary">Agregar Empresa</a> -->
        </div>
        </ul>
      </nav>  <!-- /.sidebar-menu -->
    </div>  <!-- /.sidebar -->
</aside>
@endsection

@section('content')
    <form action="{{route('importar_balance')}}" method = "POST" enctype="multipart/form-data" id="cargaFile">
    {{csrf_field()}}

    <input type="text" id="idEmpresa" name="idEmpresa" value = {{$idEmpresa}} style="display: none">
    <input type="number" id="indicadorTipoEF" name="indicadorTipoEF" value = 2 style="display: none">

    <h2>Importar Estado de Resultado para {{$nameEmpresa}}</h2>
    <p>Seleccione el archivo</p>
        <input type="file" name="balance" id="balance" onchange="return validarExt()" />
        <br> 
        <br> 
     
       
  
    <div id = "mostraContenido" style="display: none">

    <label >Periodo Contable</label>
    <select name="periodoContable" id="periodoContable" required>
      @foreach ($arrayPeriodos as $periodo)
      <option value="{{$periodo}}">{{$periodo}}</option>
      @endforeach
    </select>

      <input type="submit" value="Cargar Estado R" >
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

@endsection