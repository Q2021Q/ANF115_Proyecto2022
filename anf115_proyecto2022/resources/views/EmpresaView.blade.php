@extends('layouts.app')
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
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
          <a href="#" class="d-block"></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <div>
           <a href="{{route('empresa_insert')}}" class="btn btn-primary">Agregar Empresa</a> -->
        </div>
        </ul>
      </nav>  <!-- /.sidebar-menu -->
    </div>  <!-- /.sidebar -->
</aside>
@endsection
@section('content')
<h1>Vista Empresa</h1>
<!-- Esta forma es para php nativo -->
<!-- for de tipo blade las mas eficientes integradas en las ultimas verciones de larabel -->
<h2> valor de {{$x}}</h2>
<h2>{{$y}}</h2>

<!-- Salir es el name (->name('salir_salir')) de la ruta  en el archivo web.php en la carpeta routes -->
 <a href="{{route('salir_salir')}}">Salir</a> <!--redireccionar -->
 @endsection
