<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Periodocontable;
use App\Models\Ratio;
use App\Models\Tiporatio;
use App\Models\Ratiogeneral;
use App\Models\Cuentapuente;
use App\Models\Cuentageneral;

use RealRashid\SweetAlert\Facades\Alert;

class RazonFinanciera{

    public $valoRatio;

    public function getRatioGeneral($tipoRatio){
        $ratiosLiquidez = Ratio::join('Ratiogeneral','Ratiogeneral.idgeneralratio', '=', 'Ratio.idratio')
                          ->select('Ratiogeneral.valorratiogeneral', 'Ratio.nombreratio')
                          ->where('idtiporatio', '=', $tipoRatio)
                          ->orderBy('idgeneralratio')
                          ->get();
                         // echo $ratiosLiquidez;
                         // dd($ratiosLiquidez);
        $arrayRatiosGenerales = array();  
        array_push($arrayRatiosGenerales, "Ratios Generales"); 
                     
       foreach($ratiosLiquidez as $elemento){
        array_push($arrayRatiosGenerales, $elemento->valorratiogeneral); 
       }                  

      // dd($arrayRatiosGenerales);
      return $arrayRatiosGenerales;
    }


    public function getSaldoCuenta($idEmpresa, $periodoContable, $codigoCuentaRatio){
        $cuentaRatio = Cuentapuente::select(['codigocuenta'])->where('idempresa', '=', $idEmpresa)
                                                              ->where('year', '=', $periodoContable)
                                                              ->where('codcuentaratio', '=', $codigoCuentaRatio)
                                                              ->get();
         $saldoCuenta = -1;                                                     
        if(!$cuentaRatio->isEmpty()){
             $cuentaRatio = Cuentageneral::select(['saldo'])->where('idempresa', '=', $idEmpresa)
                                        ->where('year', '=', $periodoContable)
                                        ->where('codigocuenta', '=', $cuentaRatio[0]->codigocuenta)
                                        ->get();

            $saldoCuenta  = $cuentaRatio[0]->saldo;                         

        }  
        
        return $saldoCuenta;
    }

    public function calcularRatiosLiquidez($idEmpresa, $periodoContable, $nombreEmpresa){

        $RazonFinanciera = new RazonFinanciera();

        $activoCorrienta = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'II');
        $pasivoCorrienta = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'I');
        $inventario = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'IV');
        $activoTotal = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'VI');
      
        
        if($activoCorrienta != -1 && $pasivoCorrienta !=-1){
            /* II/I */
          $liquidezCorriente =   round($activoCorrienta/$pasivoCorrienta, 2);
        }
        else
        $liquidezCorriente = -1;


        if($activoCorrienta != -1 && $pasivoCorrienta !=-1 && $inventario !=-1){
          /* (II-IV)/I */
          $pruebaAcida = round(($activoCorrienta-$inventario)/$pasivoCorrienta, 2);
        }
        else
        $pruebaAcida = -1;


        if($activoCorrienta != -1 && $pasivoCorrienta !=-1 && $activoTotal !=-1){
          /* (II-I)/VI */
          $razonCapital = round(($activoCorrienta-$pasivoCorrienta)/$activoTotal, 2);
        }
        else
        $razonCapital = -1;


       
        $arrayRatioCalculadoLiquidez = array();  
        array_push($arrayRatioCalculadoLiquidez, $nombreEmpresa); 
        array_push($arrayRatioCalculadoLiquidez, $liquidezCorriente); 
        array_push($arrayRatioCalculadoLiquidez, $pruebaAcida);
        array_push($arrayRatioCalculadoLiquidez, $razonCapital);
        

        return $arrayRatioCalculadoLiquidez;

    }

    
    public function calcularRatiosLiquidezPromedioEmpresarial($idEmpresa, $periodoContable){

      $RazonFinanciera = new RazonFinanciera();

      $rubroMiEmpresa = Empresa::select(['idrubroempresa'])->where('idempresa', '=', $idEmpresa)->get();
     // echo $rubroMiEmpresa[0]->idrubroempresa;

      $listEmpresa = Empresa::all();

      $liquidezCorrienteSumatoria = 0;
      $pruebaAcidaSumatoria = 0;
      $razonCapitalSumatoria = 0;

      $liquidezCcontatador = 0;
      $pruebaAcidaContador = 0;
      $razonCapitalContador = 0;

      foreach($listEmpresa as $empresa){
        
        $rubroEmpresa = Empresa::select(['idrubroempresa'])->where('idempresa', '=', $empresa->IDEMPRESA)->get();
       // echo $rubroEmpresa[0]->idrubroempresa;

        if($rubroMiEmpresa[0]->idrubroempresa == $rubroEmpresa[0]->idrubroempresa){

              $activoCorrienta = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'II');
              $pasivoCorrienta = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'I');
              $inventario = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'IV');
              $activoTotal = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'VI');
      
                if($activoCorrienta != -1 && $pasivoCorrienta !=-1){
                    /* II/I */
                    $liquidezCorrienteSumatoria = $liquidezCorrienteSumatoria + $activoCorrienta/$pasivoCorrienta;
                    $liquidezCcontatador = $liquidezCcontatador + 1;
                }
      
                if($activoCorrienta != -1 && $pasivoCorrienta !=-1 && $inventario !=-1){
                  /* (II-IV)/I */
                  $pruebaAcidaSumatoria = $pruebaAcidaSumatoria + ($activoCorrienta-$inventario)/$pasivoCorrienta;
                  $pruebaAcidaContador = $pruebaAcidaContador +1;
                  }
      
                if($activoCorrienta != -1 && $pasivoCorrienta !=-1 && $activoTotal !=-1){
                  /* (II-I)/VI */
                  $razonCapitalSumatoria = $razonCapitalSumatoria + ($activoCorrienta-$pasivoCorrienta)/$activoTotal;
                  $razonCapitalContador = $razonCapitalContador +1;
                }

        }

      }
    
      $promedioLiquidez = -1;
      if($liquidezCorrienteSumatoria != 0){

        $promedioLiquidez = round($liquidezCorrienteSumatoria/$liquidezCcontatador, 2);

      }

      $promedioPruebaAsida = -1;
      if($pruebaAcidaSumatoria != 0){

        $promedioPruebaAsida = round($pruebaAcidaSumatoria/$pruebaAcidaContador, 2);

      }

      $promedioRazonCapital = -1;
      if($razonCapitalSumatoria  != 0){

        $promedioRazonCapital = round($razonCapitalSumatoria /$razonCapitalContador, 2);

      }


     
      $arrayPromedioRatioCalculadoLiquidez = array();  
      array_push($arrayPromedioRatioCalculadoLiquidez, "Promedio Empresarial"); 
      array_push($arrayPromedioRatioCalculadoLiquidez, $promedioLiquidez); 
      array_push($arrayPromedioRatioCalculadoLiquidez, $promedioPruebaAsida);
      array_push($arrayPromedioRatioCalculadoLiquidez, $promedioRazonCapital);
      

      return $arrayPromedioRatioCalculadoLiquidez;

  }



    public function calcularRatiosEficiencia($idEmpresa, $periodoContable, $nombreEmpresa){

        $RazonFinanciera = new RazonFinanciera();

        $utilidadBruta = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'X');
        $ventas = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'IX');
        $utilidadOperativa = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'XI');

        if($utilidadBruta != -1 && $ventas !=-1){
            /* X/IX */
          $indiceMargenBruto =   round($utilidadBruta/$ventas, 2);
        }
        else
        $indiceMargenBruto = -1;


        if($utilidadOperativa != -1 && $ventas !=-1){
            /* XI/IX */
          $indiceMargenOperativo =   round($utilidadOperativa/$ventas, 2);
        }
        else
        $indiceMargenOperativo = -1;


        $arrayRatioCalculadoEficiencia = array();  
        array_push($arrayRatioCalculadoEficiencia, $nombreEmpresa); 
        array_push($arrayRatioCalculadoEficiencia, $indiceMargenBruto); 
        array_push($arrayRatioCalculadoEficiencia, $indiceMargenOperativo);

        return $arrayRatioCalculadoEficiencia;

    }


public function calcularRatiosEficienciaPromedioEmpresarial($idEmpresa, $periodoContable){

  $RazonFinanciera = new RazonFinanciera();

  $listEmpresa = Empresa::all();

  $indiceMargenBrutoSumatoria = 0;
  $indiceMargenOperativoSumatoria = 0;


  $indiceMargenBrutoContador = 0;
  $indiceMargenOperativoContador = 0;

  foreach($listEmpresa as $empresa){

    $utilidadBruta = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'X');
    $ventas = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'IX');
    $utilidadOperativa = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'XI');

    if($utilidadBruta != -1 && $ventas !=-1){
        /* X/IX */
        $indiceMargenBrutoSumatoria = $indiceMargenBrutoSumatoria +  ($utilidadBruta/$ventas);
        $indiceMargenBrutoContador = $indiceMargenBrutoContador + 1;
    }

    if($utilidadOperativa != -1 && $ventas !=-1){
        /* XI/IX */
        $indiceMargenOperativoSumatoria = $indiceMargenOperativoSumatoria + ($utilidadOperativa/$ventas);
        $indiceMargenOperativoContador =  $indiceMargenOperativoContador + 1;
    }

  }

  $indiceMargenBrutoPromedio = -1;
  if($indiceMargenBrutoSumatoria  != 0){

    $indiceMargenBrutoPromedio = round($indiceMargenBrutoSumatoria /$indiceMargenBrutoContador, 2);

  }

  $indiceMargenOperativoPromedio = -1;
  if($indiceMargenOperativoSumatoria  != 0){

    $indiceMargenOperativoPromedio = round($indiceMargenOperativoSumatoria /$indiceMargenOperativoContador, 2);

  }

  $arrayRatioPromedioEmpresarialEficiencia = array();  
  array_push($arrayRatioPromedioEmpresarialEficiencia, "Promedio Empresarial"); 
  array_push($arrayRatioPromedioEmpresarialEficiencia, $indiceMargenBrutoPromedio); 
  array_push($arrayRatioPromedioEmpresarialEficiencia, $indiceMargenOperativoPromedio);

  return $arrayRatioPromedioEmpresarialEficiencia;

}


    public function calcularRatiosRentabilidad($idEmpresa, $periodoContable, $nombreEmpresa){

        $RazonFinanciera = new RazonFinanciera();

        $utilidadBruta = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'X');
        $ventas = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'IX');
        $costoVenta = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'III');
        $utilidadNeta = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'VIII');

        if($utilidadNeta != -1 && $ventas !=-1){
            /* VIII/IX */
          $rentabilidaSventa =   round($utilidadNeta/$ventas, 2);
        }
        else
        $rentabilidaSventa = -1;
        

        if($utilidadBruta != -1 && $costoVenta !=-1){
            /* X/III */
          $rentabilidaSinvercion =   round($utilidadBruta/$costoVenta, 2);
        }
        else
        $rentabilidaSinvercion = -1;

        $arrayRatioCalculadoRentabilidad = array();  
        array_push($arrayRatioCalculadoRentabilidad, $nombreEmpresa); 
        array_push($arrayRatioCalculadoRentabilidad, $rentabilidaSventa); 
        array_push($arrayRatioCalculadoRentabilidad, $rentabilidaSinvercion);

        return $arrayRatioCalculadoRentabilidad;

    }

    
    public function calcularRatiosRentabilidadPromedioEmpresarial($idEmpresa, $periodoContable){

      $RazonFinanciera = new RazonFinanciera();

      $listEmpresa = Empresa::all();

      $rentabilidaSventaSumatoria = 0;
      $rentabilidaSinvercionSumatoria = 0;


      $rentabilidaSventaContador = 0;
      $rentabilidaSinvercionContador = 0;

      foreach($listEmpresa as $empresa){

          $utilidadBruta = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'X');
          $ventas = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'IX');
          $costoVenta = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'III');
          $utilidadNeta = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'VIII');

            if($utilidadNeta != -1 && $ventas !=-1){
              /* VIII/IX */
              $rentabilidaSventaSumatoria = $rentabilidaSventaSumatoria + $utilidadNeta/$ventas;
              $rentabilidaSventaContador = $rentabilidaSventaContador + 1;
            }
          
          
          if($utilidadBruta != -1 && $costoVenta !=-1){
              /* X/III */
              $rentabilidaSinvercionSumatoria = $rentabilidaSinvercionSumatoria + $utilidadBruta/$costoVenta;
              $rentabilidaSinvercionContador = $rentabilidaSinvercionContador + 1;
          }
        
      }

      $rentabilidaSventaPromedio = -1;
      if($rentabilidaSventaSumatoria  != 0){
    
        $rentabilidaSventaPromedio = round($rentabilidaSventaSumatoria / $rentabilidaSventaContador, 2);
    
      }

      $rentabilidaSinvercionPromedio = -1;
      if($rentabilidaSinvercionSumatoria  != 0){
    
        $rentabilidaSinvercionPromedio = round($rentabilidaSinvercionSumatoria / $rentabilidaSinvercionContador, 2);
    
      }

    

      $arrayRatioPromedioRentabilidad = array();  
      array_push($arrayRatioPromedioRentabilidad, "Promedio Empresarial"); 
      array_push($arrayRatioPromedioRentabilidad, $rentabilidaSventaPromedio); 
      array_push($arrayRatioPromedioRentabilidad, $rentabilidaSinvercionPromedio);

      return $arrayRatioPromedioRentabilidad;

  }


    public function calcularRatiosEndeudamiento($idEmpresa, $periodoContable, $nombreEmpresa){

        $RazonFinanciera = new RazonFinanciera();

        $ventas = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'IX');
        $activoCorriente = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'II');
        $patrimonio = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'VII');
        $utilidadNeta = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'VIII');

        if($utilidadNeta != -1 && $ventas !=-1){
            /* VIII/IX */
          $margenNeto =   round($utilidadNeta/$ventas, 2);
        }
        else
        $margenNeto = -1;


        if($activoCorriente != -1 && $ventas !=-1){
            /* IX/II */
          $rotacionActivos =   round($ventas/$activoCorriente, 2);
        }
        else
        $rotacionActivos = -1;


        if($activoCorriente != -1 && $patrimonio !=-1){
            /* II/VII */
          $multiplicadorCapitgal =   round($activoCorriente/$patrimonio, 2);
        }
        else
        $multiplicadorCapitgal = -1;

        $arrayRatioCalculadoEndeudamiento = array();  
        array_push($arrayRatioCalculadoEndeudamiento, $nombreEmpresa); 
        array_push($arrayRatioCalculadoEndeudamiento, $margenNeto); 
        array_push($arrayRatioCalculadoEndeudamiento, $rotacionActivos); 
        array_push($arrayRatioCalculadoEndeudamiento, $multiplicadorCapitgal);

        return $arrayRatioCalculadoEndeudamiento;


    }


public function calcularRatiosEndeudamientoPromedioEmpresarial($idEmpresa, $periodoContable){

  $RazonFinanciera = new RazonFinanciera();
 $listEmpresa = Empresa::all();

      $margenNetoSumatoria = 0;
      $rotacionActivosSumatoria = 0;
      $multiplicadorCapitgalSumatoria = 0;

      $margenNetoContador = 0;
      $rotacionActivosContador = 0;
      $multiplicadorCapitgalContador = 0;

    foreach($listEmpresa as $empresa){
        $ventas = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'IX');
        $activoCorriente = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'II');
        $patrimonio = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'VII');
        $utilidadNeta = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'VIII');

        if($utilidadNeta != -1 && $ventas !=-1){
            /* VIII/IX */
            $margenNetoSumatoria = $margenNetoSumatoria + $utilidadNeta/$ventas;
            $margenNetoContador = $margenNetoContador + 1;
        }

        if($activoCorriente != -1 && $ventas !=-1){
          /* IX/II */
          $rotacionActivosSumatoria = $rotacionActivosSumatoria + $ventas/$activoCorriente;
          $rotacionActivosContador = $rotacionActivosContador + 1;
        }

        if($activoCorriente != -1 && $patrimonio !=-1){
          /* II/VII */
          $multiplicadorCapitgalSumatoria = $multiplicadorCapitgalSumatoria + $activoCorriente/$patrimonio;
          $multiplicadorCapitgalContador = $multiplicadorCapitgalContador + 1;
        }

    }

  
  $margenNetoPromedio = -1;
  if($margenNetoSumatoria  != 0){

    $margenNetoPromedio = round($margenNetoSumatoria / $margenNetoContador, 2);
  }

  
  $rotacionActivosPromedio = -1;
  if($rotacionActivosSumatoria  != 0){

    $rotacionActivosPromedio = round($rotacionActivosSumatoria / $rotacionActivosContador, 2);
  }


  $multiplicadorCapitgalPromedio = -1;
  if($multiplicadorCapitgalSumatoria  != 0){

    $multiplicadorCapitgalPromedio = round($multiplicadorCapitgalSumatoria / $multiplicadorCapitgalContador, 2);
  } 

  $arrayRatioPromedioEndeudamiento = array();  
  array_push($arrayRatioPromedioEndeudamiento, "Promedio Empresarial"); 
  array_push($arrayRatioPromedioEndeudamiento, $margenNetoPromedio); 
  array_push($arrayRatioPromedioEndeudamiento, $rotacionActivosPromedio); 
  array_push($arrayRatioPromedioEndeudamiento, $multiplicadorCapitgalPromedio);

  return $arrayRatioPromedioEndeudamiento;


}

    public function calcularRatiosApalancamiento($idEmpresa, $periodoContable, $nombreEmpresa){

        $RazonFinanciera = new RazonFinanciera();

        $pasivoTotal = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'V');
        $activoTotal = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'VI');
        $patrimonio = $RazonFinanciera->getSaldoCuenta($idEmpresa, $periodoContable, 'VII');

        if($pasivoTotal != -1 && $activoTotal !=-1){
            /* V/VI */
          $gradoEndeudamiento =   round($pasivoTotal/$activoTotal, 2);
        }
        else
        $gradoEndeudamiento = -1;


        if($patrimonio != -1 && $activoTotal !=-1){
            /* VII/VI */
          $gradoPropiedad =   round($patrimonio/$activoTotal, 2);
        }
        else
        $gradoPropiedad = -1;


        if($pasivoTotal != -1 &&  $patrimonio !=-1){
            /* V/VII */
          $endeudamientoPatrimonial =   round($pasivoTotal/ $patrimonio, 2);
        }
        else
        $endeudamientoPatrimonial = -1;

        $arrayRatioCalculadoApalancamiento = array();  
        array_push($arrayRatioCalculadoApalancamiento, $nombreEmpresa); 
        array_push($arrayRatioCalculadoApalancamiento, $gradoEndeudamiento); 
        array_push($arrayRatioCalculadoApalancamiento, $gradoPropiedad); 
        array_push($arrayRatioCalculadoApalancamiento, $endeudamientoPatrimonial); 

        return $arrayRatioCalculadoApalancamiento;

    }

    //----------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------
    //--------------------------------
    public function calcularRatiosApalancamientoPromedioEmpresarial($idEmpresa, $periodoContable){

      $RazonFinanciera = new RazonFinanciera();

      
      $listEmpresa = Empresa::all();

      $gradoEndeudamientoSumatoria = 0;
      $gradoPropiedadSumatoria = 0;
      $endeudamientoPatrimonialSumatoria = 0;

      $gradoEndeudamientoContador = 0;
      $gradoPropiedadContador = 0;
      $endeudamientoPatrimonialContador = 0;

    foreach($listEmpresa as $empresa){
      $pasivoTotal = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'V');
      $activoTotal = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'VI');
      $patrimonio = $RazonFinanciera->getSaldoCuenta($empresa->IDEMPRESA, $periodoContable, 'VII');

      if($pasivoTotal != -1 && $activoTotal !=-1){
        /* V/VI */
        $gradoEndeudamientoSumatoria = $gradoEndeudamientoSumatoria + $pasivoTotal/$activoTotal;
        $gradoEndeudamientoContador = $gradoEndeudamientoContador + 1;
      }

      if($patrimonio != -1 && $activoTotal !=-1){
        /* VII/VI */
        $gradoPropiedadSumatoria = $gradoPropiedadSumatoria + $patrimonio/$activoTotal;
        $gradoPropiedadContador = $gradoPropiedadContador + 1;
      }

      if($pasivoTotal != -1 &&  $patrimonio !=-1){
          /* V/VII */
          $endeudamientoPatrimonialSumatoria = $endeudamientoPatrimonialSumatoria + $pasivoTotal/ $patrimonio;
          $endeudamientoPatrimonialContador = $endeudamientoPatrimonialContador + 1;
      }

    }

      
      $gradoEndeudamientoPromedio = -1;
      if($gradoEndeudamientoSumatoria  != 0){

        $gradoEndeudamientoPromedio = round($gradoEndeudamientoSumatoria / $gradoEndeudamientoContador, 2);
      }

      
    
      $gradoPropiedadPromedio = -1;
      if($gradoPropiedadSumatoria  != 0){

        $gradoPropiedadPromedio = round($gradoPropiedadSumatoria / $gradoPropiedadContador, 2);
      }

      $endeudamientoPatrimonialPromedio = -1;
      if($endeudamientoPatrimonialSumatoria  != 0){

        $endeudamientoPatrimonialPromedio = round($endeudamientoPatrimonialSumatoria / $endeudamientoPatrimonialContador, 2);
      }

      $arrayRatioPromedioApalancamiento = array();  
      array_push($arrayRatioPromedioApalancamiento, "Promedio Empresarial"); 
      array_push($arrayRatioPromedioApalancamiento, $gradoEndeudamientoPromedio); 
      array_push($arrayRatioPromedioApalancamiento, $gradoPropiedadPromedio); 
      array_push($arrayRatioPromedioApalancamiento, $endeudamientoPatrimonialPromedio); 

      return $arrayRatioPromedioApalancamiento;

  }
  //**********************************************************************----------------------------- */
  //////////////////////-------------------
 
}



class RatioController extends Controller
{
    //

    public function comparacionRatioGeneraRedirec($idEmpresa){

     
        $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
        $nomEmpresa = $nombreEmpresa[0]->nombreempresa;


        $periodosContable = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();
        $listRatio = Tiporatio::all();

        $nombreTipoComparacion = "Comparacion por ratios generales";

        $ratioX3 = TRUE;
        $apalancamiento = FALSE;
        $endeudamiento = FALSE;
        $comparacionPeriodoAperiodoB = FALSE;
        $tipoRazon = "Razones de Liquidez";

        $nombreRatio1 = "Liquidez corriente";
        $nombreRatio2 = "Prueba Acida";
        $nombreRatio3 = "Razon de capital de trabajo";
        $arrayRatioGeneral = array();
        $arrayRatioGeneralVacio = TRUE;
        return view('ComparacionRatioGeneralView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'comparacionPeriodoAperiodoB'));

    }

    public function comparacionRatioGeneral(Request $request){

        $idEmpresa = $request->idEmpresa;
        $periodoContable = $request->periodoContable;
     
        $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
        $nomEmpresa = $nombreEmpresa[0]->nombreempresa;


        $periodosContable = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();
        $listRatio = Tiporatio::all();

        $nombreTipoComparacion = "Comparacion por ratios generales";

        $ratioX3 = TRUE;
        $apalancamiento = FALSE;
        $endeudamiento = FALSE;
        $comparacionPeriodoAperiodoB = FALSE;
        $arrayRatioGeneralVacio = FALSE;//para cuanto entra desde el otro metodo
        $tipoRazon = "Razones de Liquidez periodo contable ". $periodoContable;

        $nombreRatio1 = "Liquidez corriente";
        $nombreRatio2 = "Prueba Acida";
        $nombreRatio3 = "Razon de capital de trabajo";

        $RazonFinanciera = new RazonFinanciera();
        $arrayRatioGeneral = array();
        $arrayRatios = array();

        switch ($request->tipoRatio) {
            case 1:
                //LIQUIDEZ
                $arrayRatioLiquidez = $RazonFinanciera->getRatioGeneral(1);
                $arrayRatioGeneral =  $arrayRatioLiquidez;

               $arrayRatios = $RazonFinanciera->calcularRatiosLiquidez($idEmpresa, $periodoContable, $nomEmpresa);

                return view('ComparacionRatioGeneralView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

                break;
            case 2:

                //EFICIENCIA
                $ratioX3 = FALSE;
                $tipoRazon = "Razones de Eficiencia periodo contable ". $periodoContable;
                $nombreRatio1 = "Índice de Margen Bruto";
                $nombreRatio2 = "Índice de Margen Operativo";
               
                $arrayRatios = $RazonFinanciera->calcularRatiosEficiencia($idEmpresa, $periodoContable, $nomEmpresa);

                $arrayRatioEficiencia = $RazonFinanciera->getRatioGeneral(2);
                $arrayRatioGeneral =  $arrayRatioEficiencia;
                return view('ComparacionRatioGeneralView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

                break;
            case 3:
                //RENTABILIDAD
                $arrayRatioRentabilidad = $RazonFinanciera->getRatioGeneral(3);
                $arrayRatioGeneral =  $arrayRatioRentabilidad;

                $arrayRatios = $RazonFinanciera->calcularRatiosRentabilidad($idEmpresa, $periodoContable, $nomEmpresa);

                $ratioX3 = FALSE;
                $tipoRazon = "Razones de Rentabilidad periodo contable ". $periodoContable;
                $nombreRatio1 = "Rentabilidad sobre ventas";
                $nombreRatio2 = "Rentabilidad sobre inversión(ROI)";
                return view('ComparacionRatioGeneralView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

                break;
            case 4:
                //ENDEUDAMIENTO
                $endeudamiento = TRUE;

                $arrayRatioEndeudamiento = $RazonFinanciera->getRatioGeneral(4);
                $arrayRatioGeneral =  $arrayRatioEndeudamiento;

                $arrayRatios = $RazonFinanciera->calcularRatiosEndeudamiento($idEmpresa, $periodoContable, $nomEmpresa);

                $ratioX3 = TRUE;
                $tipoRazon = "Razones de Endeudamiento periodo contable ". $periodoContable;
                $nombreRatio1 = "Margen Neto";
                $nombreRatio2 = "Rotación de activos";
                $nombreRatio3 = "Multiplicador de capital";
                return view('ComparacionRatioGeneralView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

                break;
            case 5:
                //APALANCAMIENTO

                $arrayRatioApalancamiento = $RazonFinanciera->getRatioGeneral(5);
                $arrayRatioGeneral =  $arrayRatioApalancamiento;

                $arrayRatios = $RazonFinanciera->calcularRatiosApalancamiento($idEmpresa, $periodoContable, $nomEmpresa);
                
                $ratioX3 = TRUE;
                $apalancamiento = TRUE;
                $tipoRazon = "Razones de Apalancamiento periodo contable ". $periodoContable;
                $nombreRatio1 = "Grado de Endeudamiento";
                $nombreRatio2 = "Grado de Propiedad";
                $nombreRatio3 = "Endeudamiento Patrimonial";
                return view('ComparacionRatioGeneralView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

                break;    
        }

    }

    public function comparacionRatioPeriodoA_periodoB_Redirec($idEmpresa){

     
      $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
      $nomEmpresa = $nombreEmpresa[0]->nombreempresa;


      $periodosContable = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();
      $listRatio = Tiporatio::all();

      $nombreTipoComparacion = "Comparacion de ratios en dos periodos";

      $ratioX3 = TRUE;
      $apalancamiento = FALSE;
      $endeudamiento = FALSE;
      $comparacionPeriodoAperiodoB = TRUE;
      $tipoRazon = "Razones de Liquidez";

      $nombreRatio1 = "Liquidez corriente";
      $nombreRatio2 = "Prueba Acida";
      $nombreRatio3 = "Razon de capital de trabajo";
      $arrayRatioGeneral = array();
      $arrayRatioGeneralVacio = TRUE;
      return view('ComparacionRatioPeriodoABview', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'comparacionPeriodoAperiodoB'));

  }

  public function comparacionRatioPeriodoAB(Request $request){

    $idEmpresa = $request->idEmpresa;
    $periodoContable = $request->periodoContable;
    $periodoContableB = $request->periodoContableB;


 
    $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
    $nomEmpresa = $nombreEmpresa[0]->nombreempresa;


    $periodosContable = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();
    $listRatio = Tiporatio::all();

    $nombreTipoComparacion = "Comparacion de ratios en dos periodos";

    $ratioX3 = TRUE;
    $apalancamiento = FALSE;
    $endeudamiento = FALSE;
    $comparacionPeriodoAperiodoB = FALSE;
    $arrayRatioGeneralVacio = FALSE;//para cuanto entra desde el otro metodo
    $tipoRazon = "Razones de Liquidez periodo contable ". $periodoContable. " - " .$periodoContableB;

    $nombreRatio1 = "Liquidez corriente";
    $nombreRatio2 = "Prueba Acida";
    $nombreRatio3 = "Razon de capital de trabajo";

    $RazonFinanciera = new RazonFinanciera();
    $arrayRatioGeneral = array();
    $arrayRatios = array();

    if($periodoContable==$periodoContableB){
      $arrayRatioGeneralVacio = TRUE;
      Alert::warning('Periodos Iguales', 'Seleccione Periodos distintos');
      return view('ComparacionRatioPeriodoABview', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'comparacionPeriodoAperiodoB'));
    }

    switch ($request->tipoRatio) {
        case 1:
            //LIQUIDEZ
           $nomEmpresa_periodoA = $nomEmpresa." ".$periodoContable;
           $arrayRatioGeneral = $RazonFinanciera->calcularRatiosLiquidez($idEmpresa, $periodoContable, $nomEmpresa_periodoA);;

           $nomEmpresa_periodoB = $nomEmpresa." ".$periodoContableB;
           $arrayRatios = $RazonFinanciera->calcularRatiosLiquidez($idEmpresa, $periodoContableB, $nomEmpresa_periodoB);

            return view('ComparacionRatioPeriodoABview', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

            break;
        case 2:

            //EFICIENCIA
            $ratioX3 = FALSE;
            $tipoRazon = "Razones de Eficiencia periodo contable ". $periodoContable. " - " .$periodoContableB;
            $nombreRatio1 = "Índice de Margen Bruto";
            $nombreRatio2 = "Índice de Margen Operativo";
           
            $nomEmpresa_periodoA = $nomEmpresa." ".$periodoContable;
            $arrayRatioGeneral = $RazonFinanciera->calcularRatiosEficiencia($idEmpresa, $periodoContable, $nomEmpresa_periodoA);

            $nomEmpresa_periodoB = $nomEmpresa." ".$periodoContableB;
            $arrayRatios = $RazonFinanciera->calcularRatiosEficiencia($idEmpresa, $periodoContableB, $nomEmpresa_periodoB);

           
            return view('ComparacionRatioPeriodoABview', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

            break;
        case 3:
            //RENTABILIDAD
            $nomEmpresa_periodoA = $nomEmpresa." ".$periodoContable;
            $arrayRatioGeneral = $RazonFinanciera->calcularRatiosRentabilidad($idEmpresa, $periodoContable, $nomEmpresa_periodoA);

            $nomEmpresa_periodoB = $nomEmpresa." ".$periodoContableB;
            $arrayRatios = $RazonFinanciera->calcularRatiosRentabilidad($idEmpresa, $periodoContableB, $nomEmpresa_periodoB);


            $ratioX3 = FALSE;
            $tipoRazon = "Razones de Rentabilidad periodo contable ". $periodoContable. " - " .$periodoContableB;
            $nombreRatio1 = "Rentabilidad sobre ventas";
            $nombreRatio2 = "Rentabilidad sobre inversión(ROI)";
            return view('ComparacionRatioPeriodoABview', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

            break;
        case 4:
            //ENDEUDAMIENTO
            $endeudamiento = TRUE;


            $nomEmpresa_periodoA = $nomEmpresa." ".$periodoContable;
            $arrayRatioGeneral = $RazonFinanciera->calcularRatiosEndeudamiento($idEmpresa, $periodoContable, $nomEmpresa_periodoA);

            $nomEmpresa_periodoB = $nomEmpresa." ".$periodoContableB;
            $arrayRatios = $RazonFinanciera->calcularRatiosEndeudamiento($idEmpresa, $periodoContableB, $nomEmpresa_periodoB);


            $ratioX3 = TRUE;
            $tipoRazon = "Razones de Endeudamiento periodo contable ". $periodoContable. " - " .$periodoContableB;
            $nombreRatio1 = "Margen Neto";
            $nombreRatio2 = "Rotación de activos";
            $nombreRatio3 = "Multiplicador de capital";
            return view('ComparacionRatioPeriodoABview', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

            break;
        case 5:
            //APALANCAMIENTO

            $arrayRatioApalancamiento = $RazonFinanciera->getRatioGeneral(5);
            $arrayRatioGeneral =  $arrayRatioApalancamiento;

            $nomEmpresa_periodoA = $nomEmpresa." ".$periodoContable;
            $arrayRatioGeneral = $RazonFinanciera->calcularRatiosApalancamiento($idEmpresa, $periodoContable, $nomEmpresa_periodoA);

            $nomEmpresa_periodoB = $nomEmpresa." ".$periodoContableB;
            $arrayRatios = $RazonFinanciera->calcularRatiosApalancamiento($idEmpresa, $periodoContableB, $nomEmpresa_periodoB);
            
            $ratioX3 = TRUE;
            $apalancamiento = TRUE;
            $tipoRazon = "Razones de Apalancamiento periodo contable ". $periodoContable. " - " .$periodoContableB;
            $nombreRatio1 = "Grado de Endeudamiento";
            $nombreRatio2 = "Grado de Propiedad";
            $nombreRatio3 = "Endeudamiento Patrimonial";
            return view('ComparacionRatioPeriodoABview', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

            break;    
    }

 }

 public function comparacionRatioPromedioEmpresarialRedi($idEmpresa){

     
  $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
  $nomEmpresa = $nombreEmpresa[0]->nombreempresa;


  $periodosContable = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();
  $listRatio = Tiporatio::all();

  $nombreTipoComparacion = "Comparacion Promedio Empresarial";

  $ratioX3 = TRUE;
  $apalancamiento = FALSE;
  $endeudamiento = FALSE;
  $comparacionPeriodoAperiodoB = TRUE;
  $tipoRazon = "Razones de Liquidez";

  $nombreRatio1 = "Liquidez corriente";
  $nombreRatio2 = "Prueba Acida";
  $nombreRatio3 = "Razon de capital de trabajo";
  $arrayRatioGeneral = array();
  $arrayRatioGeneralVacio = TRUE;
  return view('ComparacionRatioPromedioEmpresarialView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'comparacionPeriodoAperiodoB'));

}
//------------------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
//-------------------------------------------
public function comparacionRatioPromedioEmpresarial(Request $request){

  $idEmpresa = $request->idEmpresa;
  $periodoContable = $request->periodoContable;

  $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
  $nomEmpresa = $nombreEmpresa[0]->nombreempresa;


  $periodosContable = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();
  $listRatio = Tiporatio::all();

  $nombreTipoComparacion = "Comparacion Promedio Empresarial";

  $ratioX3 = TRUE;
  $apalancamiento = FALSE;
  $endeudamiento = FALSE;
  $comparacionPeriodoAperiodoB = FALSE;
  $arrayRatioGeneralVacio = FALSE;//para cuanto entra desde el otro metodo
  $tipoRazon = "Razones de Liquidez periodo contable ". $periodoContable;

  $nombreRatio1 = "Liquidez corriente";
  $nombreRatio2 = "Prueba Acida";
  $nombreRatio3 = "Razon de capital de trabajo";

  $RazonFinanciera = new RazonFinanciera();
  $arrayRatioGeneral = array();
  $arrayRatios = array();

  switch ($request->tipoRatio) {
      case 1:
          //LIQUIDEZ
          
          $arrayRatioGeneral = $RazonFinanciera->calcularRatiosLiquidezPromedioEmpresarial($idEmpresa, $periodoContable);

         $arrayRatios = $RazonFinanciera->calcularRatiosLiquidez($idEmpresa, $periodoContable, $nomEmpresa);

          return view('ComparacionRatioPromedioEmpresarialView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

          break;
      case 2:

          //EFICIENCIA
          $ratioX3 = FALSE;
          $tipoRazon = "Razones de Eficiencia periodo contable ". $periodoContable;
          $nombreRatio1 = "Índice de Margen Bruto";
          $nombreRatio2 = "Índice de Margen Operativo";
         
          $arrayRatios = $RazonFinanciera->calcularRatiosEficiencia($idEmpresa, $periodoContable, $nomEmpresa);
          
          $arrayRatioGeneral =$RazonFinanciera->calcularRatiosEficienciaPromedioEmpresarial($idEmpresa, $periodoContable);

          return view('ComparacionRatioPromedioEmpresarialView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

          break;
      case 3:
          //RENTABILIDAD
         
          $arrayRatioGeneral = $RazonFinanciera->calcularRatiosRentabilidadPromedioEmpresarial($idEmpresa, $periodoContable);
          $arrayRatios = $RazonFinanciera->calcularRatiosRentabilidad($idEmpresa, $periodoContable, $nomEmpresa);

          $ratioX3 = FALSE;
          $tipoRazon = "Razones de Rentabilidad periodo contable ". $periodoContable;
          $nombreRatio1 = "Rentabilidad sobre ventas";
          $nombreRatio2 = "Rentabilidad sobre inversión(ROI)";
          return view('ComparacionRatioPromedioEmpresarialView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

          break;
      case 4:
          //ENDEUDAMIENTO
          $endeudamiento = TRUE;

          $arrayRatioGeneral = $RazonFinanciera->calcularRatiosEndeudamientoPromedioEmpresarial($idEmpresa, $periodoContable);

          $arrayRatios = $RazonFinanciera->calcularRatiosEndeudamiento($idEmpresa, $periodoContable, $nomEmpresa);

          $ratioX3 = TRUE;
          $tipoRazon = "Razones de Endeudamiento periodo contable ". $periodoContable;
          $nombreRatio1 = "Margen Neto";
          $nombreRatio2 = "Rotación de activos";
          $nombreRatio3 = "Multiplicador de capital";
          return view('ComparacionRatioPromedioEmpresarialView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

          break;
      case 5:
          //APALANCAMIENTO

          $arrayRatioGeneral = $RazonFinanciera->calcularRatiosApalancamientoPromedioEmpresarial($idEmpresa, $periodoContable);

          $arrayRatios = $RazonFinanciera->calcularRatiosApalancamiento($idEmpresa, $periodoContable, $nomEmpresa);
          
          $ratioX3 = TRUE;
          $apalancamiento = TRUE;
          $tipoRazon = "Razones de Apalancamiento periodo contable ". $periodoContable;
          $nombreRatio1 = "Grado de Endeudamiento";
          $nombreRatio2 = "Grado de Propiedad";
          $nombreRatio3 = "Endeudamiento Patrimonial";
          return view('ComparacionRatioPromedioEmpresarialView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios', 'comparacionPeriodoAperiodoB'));

          break;    
  }

}


}
