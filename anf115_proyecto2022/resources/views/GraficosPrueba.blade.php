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
            <!-- <a href="{{route('empresa_insert')}}" class="btn btn-primary">Agregar Empresa</a> -->
        </div>
        </ul>
      </nav>  <!-- /.sidebar-menu -->
    </div>  <!-- /.sidebar -->
</aside>

@endsection

@section('content')
    <div class="col-lg-12" style="padding-top: 20px;">
        <div class="card">
            <div class="card-header">
                Grafico con Chartjs - prueba 3
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-4">
                        <div>
                            <a href="#" class= "btn btn-primary">Go somewhere</a>
                        </div>
                        <br>
                        <div>
                            <input type="text" name="txtnom" id="txtnom" class="form-control" placeholder="Buscar dato " value="">
                        </div>
                    </div>
                </div>
            </div>
            <div id="datos"></div>
            <script type="text/javascript" src="js/funcion.js"></script>
        </div>
        
    </div>
@endsection