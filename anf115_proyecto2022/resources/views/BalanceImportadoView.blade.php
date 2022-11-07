@extends('layouts.app')

<h1>{{$nomE}}</h1>


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


   
    <h2>{{$nombreEstado}}</h2>
   
    <script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </script>
    

<?php
    $mensaje_error_si_no = '';
    $sms = $mensaje;
    if($error_cuenta == TRUE){
        $mensaje_error_si_no .= '<h3  style="color:#FF0000">';
        $mensaje_error_si_no .=  $sms;
        $mensaje_error_si_no .= '</h3>';
    }
       
     else{
        $mensaje_error_si_no .= '<h3 style="color:#9A4BF9">';
        $mensaje_error_si_no .=  $sms;
        $mensaje_error_si_no .= '</h3>';
     }
        
    echo $mensaje_error_si_no;
?>
    <table border="1">
            <tr>
                <th>Codigo de la cuenta</th>
                <th>Tipo de cuenta</th>
                <th>Nombre de la cuenta</th>
                <th>Saldo de la cuenta</th>
                <th>Cuenta de ratio</th>
               
            </tr>

            <?php

    $concat = '';

    foreach ($cuentasBalance as $indice_1 => $balance) {

       

        //compara las cuentas y si encuentra repetida $error = true
        $error = false;
        foreach($cuentasInvalidas as $indice => $elemento) {
            if ($indice_1 == $indice) {
                $error = true;
            }
        }

    if($error_cuenta == TRUE){
        if($error){
            $concat .= '<tr span style="color:blue" width="50%" bgcolor=FFC0CB>';
        }
        else
             $concat .= '<tr >';
    }
    else 
        $concat .= '<tr bgcolor=#EBF5FB>';
    
        //Concatenamos las tablas en una variable, también podriamos hacer el "echo" directamente
      
        $concat .= '<td >' .$balance->get_codigoCuenta() .'</td>';
        $concat .= '<td>' . $balance->get_nombreTipoCuenta() .'</td>';
        $concat .= '<td>' . $balance->get_nombreCuenta() .'</td>';
        $concat .= '<td>' . $balance->get_saldoCuenta() .'</td>';
        $concat .= '<td>' . $balance->get_nombreCuentaRatio() .'</td>';
    
        $concat .= '</tr>';
    }

    echo $concat;
    ?>
    </table>

<script>

</script>

@endsection