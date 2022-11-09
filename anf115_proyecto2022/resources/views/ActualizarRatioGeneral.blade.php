@extends('layouts.app')
<h4>Editar Ratido</h4>

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

    <script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </script>
    
    <form action="{{route('actualizarRatioGeneral_Post')}}" method="POST">
    {{csrf_field()}}
    <div class="card border-secondary mb-3">
                    <div class="card" style="height: 20rem;">
                        <div class="card" class="card border-primary mb-3">
                            <div class="card-header text-center">
                           
                            <h2 class="h3">Ratio de {{$nombreTratio}}</h2>
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                          <br> 
                          <label for="">{{$ratioGeneral[0]->nombreratio}}</label>
                            <input type="text" id="valorRatioGeneral" name="valorRatioGeneral" value ="{{$ratioGeneral[0]->valorratiogeneral}}" required>
                            <input type="text" id="idGeneralRatio" name="idGeneralRatio" value ="{{$ratioGeneral[0]->idgeneralratio}}" style="display: none" required>

                            <br> 
                            <br> 
                            <input type="submit" value="Calcular" class="btn btn-primary">

                        </div>
                    </div>
                </div>

    </form>
   

<?php
 
?> 
<script>
    https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css
</script>

@endsection