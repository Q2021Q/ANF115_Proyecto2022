@extends('layouts.app')

<h1>{{$nomEmpresa}}</h1>


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

<form action="{{route('analisisHorizontal_Post')}}" method="POST">
    {{csrf_field()}}
    <input type="text" id="idEmpresa" name="idEmpresa" value={{$idEmpresa}} style="display: none">

    <div class="card border-secondary mb-3">
                    <div class="card" style="height: 25rem;">
                        <div class="card" class="card border-primary mb-3">
                            <div class="card-header text-center">
                           
                            <h2 class="h3">Analisis Horizontal</h2>
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                        
                            <label>Periodo Contable Inicio</label>
                                  <select  name="periodoContableA" id="periodoContableA"  class="form-select form-select-lg mb-3"  required>
                                      @foreach ($periodosContable as $periodo)
                                      <option value="{{$periodo->year}}">{{$periodo->year}}</option>
                                      @endforeach
                                  </select>
                                
                                  <br> 
                                  <br> 
                                  <label>Periodo Contable Final</label>
                                  <select  name="periodoContableB" id="periodoContableB"  class="form-select form-select-lg mb-3"  required>
                                      @foreach ($periodosContable as $periodo)
                                      <option value="{{$periodo->year}}">{{$periodo->year}}</option>
                                      @endforeach
                                  </select>
                                
                                  <br> 
                                  <br>
                                  <input type="radio" id="balance" name="balance" value="1"
                                        checked>
                                  <label for="balance">Balance General</label>
                                <br> 
                                
                                <input type="radio" id="balance" name="balance" value="2">
                                  <label for="balance">Estado Resultados</label>
                                  <br> 
                                  <br>
                            <input type="submit" value="Calcular" class="btn btn-primary">

                        </div>
                    </div>
                </div>

    </form>

   
    <script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </script>
    

<?php
   
?>
    <table  class="border-primary table  table-hover table-light">

    <?php
    $concat = '';
    $tipoCuenta = 0;
    if($peticionGet){
        if(!$error){
                $concat .= '<tr class="table-info" style="text-align:center">';

                    $concat .=  '<th>'."".'</th>';
                    $concat .=  '<th>'."Cuenta".'</th>';
                    $concat .=  '<th>'.$periodoInicio.'</th>';
                    $concat .=  '<th>'.$periodoFin.'</th>';
                    $concat .=  '<th>'."Variacion Absoluta".'</th>';
                    $concat .=  '<th>'."Variacion Relativa %".'</th>';
                        
                $concat .= '</tr>';

                
                $concat .= '<tr>';
                $concat .= '<td >' ."".'</td>';
                    $concat .= '<td>' ."".'</td>';
                    $concat .= '<td>' ."".'</td>';
                    $concat .= '<td>' ."".'</td>';
                    $concat .= '<td>' ."".'</td>';
                    $concat .= '<td>' ."".'</td>';
                $concat .= '</tr>';
       }        

    foreach ($arrayAnalisisH as $elemento) {

            //compara las cuentas y si encuentra repetida $error = true
        if(!$error){
           
            if($tipoCuenta != $elemento->idTipoCuenta){
                $tipoCuenta = $elemento->idTipoCuenta;
                foreach($arrayTipoCuenta as $tpCuenta){
                    if($tpCuenta->IDTIPOCUENTA == $elemento->idTipoCuenta){
                       $concat .= '<tr class="table-warning">';
                            $concat .= '<td >' .$tpCuenta->NOMTIPOCUENTA.'</td>';
                            $concat .= '<td >' ."".'</td>';
                            $concat .= '<td>' ."".'</td>';
                            $concat .= '<td>' ."".'</td>';
                            $concat .= '<td>' ."".'</td>';
                            $concat .= '<td>' ."".'</td>';
                        $concat .= '</tr>';
                    }
                }
            }

            $concat .= '<tr>';
        
            //Concatenamos las tablas en una variable, también podriamos hacer el "echo" directamente
            $concat .= '<td >' ."".'</td>';
            $concat .= '<td >' .$elemento->nombreCuenta.'</td>';
            $concat .= '<td style="text-align:center">' .$elemento->saldoPeriodoInicio.'</td>';
            $concat .= '<td style="text-align:center">' .$elemento->saldoPeriodoFin.'</td>';
            $concat .= '<td style="text-align:center">' .$elemento->bariacionAbsoluta.'</td>';
            $concat .= '<td style="text-align:center">' .$elemento->bariacionRelativa.'</td>';
        
            $concat .= '</tr>';
        }   

    }
    
 }

    echo $concat;
    ?>
    </table>
    <br> 
    <br> 
    <br> 
    <br> 

<script>

</script>

@endsection