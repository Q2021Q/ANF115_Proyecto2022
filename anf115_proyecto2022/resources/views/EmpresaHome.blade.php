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

    <div class="col-lg-12" style="padding-top: 20px;">
        <div class="card">
            <div class="card-header">
                Empresas
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-4">
            
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="container mt-5">
                <div class="row">
                    @foreach($listEmpresa as $empresa)
                    <div class="col-lg-4" class="card border-secondary mb-3">
                        <div class="card" style="height: 25rem;">
                            <div class="card" class="card border-primary mb-3">
                                <div class="card-header">
                                    {{$empresa->NOMBREEMPRESA}}
                                </div>
                            </div>
                            <div class="card-body" class="card-body text-secondary">
                                <a href="{{route('EmpresaGestion', $empresa->IDEMPRESA)}}">
                                    <img class="card-img-top" src="{{asset($empresa->NOMBREFOTOEMPRESA)}}" alt=""
                                        class="img-fluid">
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <br>
                <br>
                <br>
            </div>
        </div>
    </div>
@endsection