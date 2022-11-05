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
        $tipoRazon = "Razones de Liquidez";

        $nombreRatio1 = "Liquidez corriente";
        $nombreRatio2 = "Prueba Acida";
        $nombreRatio3 = "Razon de capital de trabajo";
        $arrayRatioGeneral = array();
        $arrayRatioGeneralVacio = TRUE;
        return view('ComparacionRatioGeneralView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio'));

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

                return view('ComparacionRatioGeneralView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios'));

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
                return view('ComparacionRatioGeneralView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios'));

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
                return view('ComparacionRatioGeneralView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios'));

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
                return view('ComparacionRatioGeneralView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios'));

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
                return view('ComparacionRatioGeneralView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'listRatio', 'ratioX3', 'tipoRazon', 'nombreTipoComparacion', 'nombreRatio1', 'nombreRatio2', 'nombreRatio3', 'apalancamiento', 'endeudamiento', 'arrayRatioGeneral', 'arrayRatioGeneralVacio', 'arrayRatios'));

                break;    
        }

       // dd($request);


    }
}
