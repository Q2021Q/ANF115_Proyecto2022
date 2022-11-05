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


   
    
   
    <script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </script>
    
    <form action="{{route('comparacionRatio_General_post')}}" method="POST">
    {{csrf_field()}}
    <input type="text" id="idEmpresa" name="idEmpresa" value={{$idEmpresa}} style="display: none">

    <div class="card border-secondary mb-3">
                    <div class="card" style="height: 18rem;">
                        <div class="card" class="card border-primary mb-3">
                            <div class="card-header text-center">
                           
                            <h2 class="h3">{{$nombreTipoComparacion}}</h2>
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                        
                            <label>Periodo Contable</label>
                                  <select  name="periodoContable" id="periodoContable"  class="form-select form-select-lg mb-3"  required>
                                      @foreach ($periodosContable as $periodo)
                                      <option value="{{$periodo->year}}">{{$periodo->year}}</option>
                                      @endforeach
                                  </select>
                                  <br> 
                                  <br> 
                            <label>Razon Financiera</label>
                                  <select name="tipoRatio" id="tipoRatio" name="tipoRatio" class="form-select"  required>
                                      @foreach ($listRatio as $ratio)
                                      <option value="{{$ratio->IDTIPORATIO}}">{{$ratio->NOMBRETIPORATIO}}</option>
                                      @endforeach
                                  </select>
                                  <br> 
                                  <br> 
                            <input type="submit" value="Calcular" class="btn btn-primary">

                        </div>
                    </div>
                </div>

    </form>
   

<?php
 
?>
    <table  class="border-primary table  table-hover table-light">

        <tr>
             <th colspan = "4">{{$tipoRazon}}</th>
        </tr>
       
            <tr class="table-warning">
                <th></th>
                <th>{{$nombreRatio1}}</th>
                <th>{{$nombreRatio2}}</th>
              
                <?php
                if($ratioX3){
                    echo '<th>'.$nombreRatio3.'</th>';
                }
                ?>
              
               
            </tr>

    <?php

        $concat = '';

       // foreach ($arrayRatioGeneral as $elemento) {

        

            $concat .= '<tr>';
        
            //Concatenamos las tablas en una variable, también podriamos hacer el "echo" directamente
        if(!$arrayRatioGeneralVacio){
            //Fila de ratios generales
            $concat .= '<tr >';
            $concat .= '<td class="table-warning">' .$arrayRatioGeneral[0].'</td>';
            $concat .= '<td>' .$arrayRatioGeneral[1].'</td>';
            $concat .= '<td>' .$arrayRatioGeneral[2].'</td>';
           
            if($ratioX3){
                $concat .= '<td>' .$arrayRatioGeneral[3].'</td>';
                $concat .= '</tr>';  
            }
            else
            $concat .= '</tr>';  


            //Fila de ratios Calculados
            $concat .= '<tr>';
            $concat .= '<td class="table-warning">'.$arrayRatios[0].'</td>';


            if($apalancamiento){

                if($arrayRatios[1] != -1){
                    if($arrayRatios[1] < $arrayRatioGeneral[1]){
                        $concat .= '<td class="table-info">' .$arrayRatios[1].'</td>';
                    }
                    else
                    $concat .= '<td class="table-danger">' .$arrayRatios[1].'</td>';
                }
                else
                 $concat .= '<td>' ."".'</td>';

            }
            else{
                if($arrayRatios[1] != -1){
                    if($arrayRatios[1] > $arrayRatioGeneral[1]){
                        $concat .= '<td class="table-info">' .$arrayRatios[1].'</td>';
                    }
                    else
                    $concat .= '<td class="table-danger">' .$arrayRatios[1].'</td>';
                }
                else
                 $concat .= '<td>' ."".'</td>';
            }
           

             
             if($arrayRatios[2] != -1){
                if($arrayRatios[2] > $arrayRatioGeneral[2]){
                    $concat .= '<td class="table-info">' .$arrayRatios[2].'</td>';
                }
                else
                $concat .= '<td class="table-danger">' .$arrayRatios[2].'</td>';
            }
            else
            $concat .= '<td>' ."".'</td>';
           
            

            if($ratioX3){
               
                if($endeudamiento || $apalancamiento){
                    if($arrayRatios[3] != -1){
                        if($arrayRatios[3] < $arrayRatioGeneral[3]){
                            $concat .= '<td class="table-info">' .$arrayRatios[3].'</td>';
                        }
                        else
                        $concat .= '<td class="table-danger">' .$arrayRatios[3].'</td>';
                    }
                    else
                    $concat .= '<td>' ."".'</td>';
                }
             else {

                    if($arrayRatios[3] != -1){
                        if($arrayRatios[3] > $arrayRatioGeneral[3]){
                            $concat .= '<td class="table-info">' .$arrayRatios[3].'</td>';
                        }
                        else
                        $concat .= '<td class="table-danger">' .$arrayRatios[3].'</td>';
                    }
                    else
                    $concat .= '<td>' ."".'</td>';

              }  
                
            }
          
            $concat .= '</tr>';  
        }
          
        
            $concat .= '</tr>';
      //  }

        echo $concat;
    ?>
    </table>

<script>
    https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css
</script>

@endsection