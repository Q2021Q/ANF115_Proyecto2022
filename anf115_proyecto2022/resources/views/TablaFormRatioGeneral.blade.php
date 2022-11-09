@extends('layouts.app')

<h5>Actualizar Ratio General</h5>


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
        <!-- <div class="image">
          <img src="{{ asset('vendors/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div> -->
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
    

<?php
   
?>
<div class="container">
  <div class="row">
    <div class="col-md-8">

    <table  class="border-primary table  table-hover table-light">

        <!-- <tr class="table-secondary">
            <th></th>
            <th>Ratio</th>
            <th>Valor %</th>
            <th>Opcion</th>
        </tr>
        <tr> 
        <td >.</td>
        <td ></td>
        <td ></td>
        <td ></td>    
        </tr> -->
    <?php
      $concat = '';
      $tipoCuenta = 0;
                  
    ?>
    @foreach ($listRatios as $elemento)
            <?php
            if($tipoCuenta != $elemento->idtiporatio){
                $tipoCuenta = $elemento->idtiporatio;
                foreach($tipoRatio as $tpCuenta){
                    if($tpCuenta->idtiporatio == $elemento->idtiporatio){
                       $concat .= '<tr class="table-info">';
                            $concat .= '<td >' .$tpCuenta->nombretiporatio.'</td>';
                            $concat .= '<td ></td>';
                            $concat .= '<td ></td>';
                            $concat .= '<td ></td>';
                        $concat .= '</tr>';
                        echo $concat;
                        $concat = '';
                    }
                }
             }
             
             ?>
          <tr>
              <td ></td>
              <td>{{$elemento->nombreratio}}</td>
              <td>{{$elemento->valorratiogeneral}}</td>
              <td><a class="btn btn-secondary" href="{{route('actualizarRatioGenera_', $elemento->idgeneralratio)}}">Editar</a></td>        
          </tr>
@endforeach
    </table>
    </div>
  </div>
</div>
    <br> 
    <br> 
    <br> 
    <br> 

<script>

</script>

@endsection