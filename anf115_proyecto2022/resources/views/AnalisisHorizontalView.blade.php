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
<style type="text/css">
.my-custom-scrollbar {
position: relative;
height: 400px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}
</style>
<form action="{{route('analisisHorizontal_Post')}}" method="POST" class="form-horizontal ">
    {{csrf_field()}}
    <input type="text" id="idEmpresa" name="idEmpresa" value={{$idEmpresa}} style="display: none">

    <div class="card border-secondary mb-3">
                    <div class="card">
                        <div class="card" class="card border-primary mb-3">
                            <div class="card-header text-center">
                           
                            <h2 class="h3">Analisis Horizontal</h2>
                            </div>
                        </div>
                        <div class="row col-sm-12">
                        <div class="row col-sm-6">
                            <label class="col-sm-5 form-label">Periodo Contable Inicio</label>
                            <div class="col-sm-7">
                                <select  name="periodoContableA" id="periodoContableA"  class="form-control"  required>
                                    @foreach ($periodosContable as $periodo)
                                    <option value="{{$periodo->year}}">{{$periodo->year}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row form-check">
                                <label class=" col-sm-6 form-label" for="balance">Balance General</label>
                                <input class="form-check-input" type="radio" id="balance" name="balance" value="1">
                               
                            </div>
                        </div>
                          <div class="row col-md-6">
                            <label class="col-sm-5 col-form-label">Periodo Contable Final</label>
                            <div class="col-sm-7">
                                <select  name="periodoContableB" id="periodoContableB"  class="form-control"  required>
                                    @foreach ($periodosContable as $periodo)
                                    <option value="{{$periodo->year}}">{{$periodo->year}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row form-check">
                                <label class=" col-sm-6 form-label" for="balance">Estado Resultados</label>
                                <input class="form-check-input" type="radio" id="balance" name="balance" value="2">
                            </div>
                        </div> 
                        <center>
                            <input type="submit" value="Calcular" class="col-lg-2 btn btn-primary"> </center>
                        </div></div>
                        </div>
                    
               

    </form>
<?php
   
?>
<div class="table-wrapper-scroll-y my-custom-scrollbar">
    <table  class="border-primary table  table-hover table-light">

    <?php
    //Esto debio ser hecho en el backend y pasarlo como array al frontend ;)
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

            //Agrega color a los valores negativos
            if ($elemento->bariacionAbsoluta<0||$elemento->bariacionRelativa<0){
                switch ($elemento->idTipoCuenta) {
                    case 1:
                        $class='table-danger';
                        break;
                    case 2:
                        $class='table-success';
                        break;
                    case 3:
                        $class='table-danger';
                        break;
                    case 4:
                        $class='table-primary';
                        break;                   
                }
                
             $concat .= '<tr class="'.$class.'">';
            }
            else{
                $concat .= '<trx|>';     
            }
        
            //Concatenamos las tablas en una variable, también podriamos hacer el "echo" directamente
            //o pudimos haberlo hecho en el backend... Piensa Mark, piensa 
           
              
           
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
    </table></div>
    
    <br> 
    @endsection
