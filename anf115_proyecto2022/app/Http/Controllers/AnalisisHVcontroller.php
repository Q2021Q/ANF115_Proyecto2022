<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periodocontable;
use App\Models\Cuentapuente;
use App\Models\Cuentageneral;
use App\Models\Empresa;//Modelo, para CURD de la empresa
use App\Models\Catalogo;
use App\Models\Tipocuentum;

use RealRashid\SweetAlert\Facades\Alert;

class AnalisisVH
{
    public $nombreCuenta;
    public $saldoPeriodoInicio;
    public $saldoPeriodoFin;
    public $bariacionAbsoluta;
    public $bariacionRelativa;
    public $idTipoCuenta;

    public function analisisHorizontal($idEmpresa, $idTipoEstadoFinanciero, $periodoInicio, $periodoFin){

        $CuentasPeriodosContableInicio = Cuentageneral::select(['codigocuenta', 'idtipocuenta', 'saldo'])
                                         ->where('idempresa', '=', $idEmpresa)
                                         ->where('year', '=', $periodoInicio)
                                         ->where('idtipoestadofinanciero', '=', $idTipoEstadoFinanciero)
                                         ->orderBy('idtipocuenta')
                                         ->get();

    // echo $periodosContable;
        //dd($periodosContable);
        $arrayElementosAnalisisH = array();
        
        foreach($CuentasPeriodosContableInicio as $cuenta){

            $analisisHorizontal = new AnalisisVH();

            $codigoCuenta = $cuenta->codigocuenta;
            $CuentaPeriodoFin = Cuentageneral::select(['saldo'])
                                            ->where('idempresa', '=', $idEmpresa)
                                            ->where('year', '=',  $periodoFin)
                                            ->where('codigocuenta', '=', $codigoCuenta)
                                            ->get();

        
            // array_push($cuentasBalance, $balanceG);

            if(!$CuentaPeriodoFin->isEmpty()){

                    $nombreCuenta = Catalogo::select(['nombrecuenta'])
                                            ->where('idempresa', '=', $idEmpresa)
                                            ->where('codigocuenta', '=', $codigoCuenta)
                                            ->get();

                $saldoA = $cuenta->saldo;  
                $saldoB = $CuentaPeriodoFin[0]->saldo;     

                $analisisHorizontal->nombreCuenta = $nombreCuenta[0]->nombrecuenta;
                $analisisHorizontal->saldoPeriodoInicio = $saldoA;
                $analisisHorizontal->saldoPeriodoFin = $saldoB;
                $analisisHorizontal->bariacionAbsoluta = $saldoB - $saldoA;
                $analisisHorizontal->bariacionRelativa = round(100*($saldoB - $saldoA)/$saldoA, 2);
                $analisisHorizontal->idTipoCuenta = $cuenta->idtipocuenta;

                array_push($arrayElementosAnalisisH, $analisisHorizontal);

             }                                    

        }
    // dd($arrayElementosAnalisisH);
   return $arrayElementosAnalisisH;
  }


  //---------------------------------------------------------------------------------------------------
  //----------------------------------------------------------
  //----------------------
  public function analisisVeritical($idEmpresa, $idTipoEstadoFinanciero, $periodoInicio, $periodoFin, $activoTotal_ventaN_PeriodoInicio, $activoTotal_ventaN_PeriodoFin){

    $CuentasPeriodosContableInicio = Cuentageneral::select(['codigocuenta', 'idtipocuenta', 'saldo'])
                                     ->where('idempresa', '=', $idEmpresa)
                                     ->where('year', '=', $periodoInicio)
                                     ->where('idtipoestadofinanciero', '=', $idTipoEstadoFinanciero)
                                     ->orderBy('idtipocuenta')
                                     ->get();

// echo $periodosContable;
    //dd($periodosContable);
    $arrayElementosAnalisisV = array();
    
    foreach($CuentasPeriodosContableInicio as $cuenta){

        $analisisVertical = new AnalisisVH();
       // $analisisHorizontal
        $codigoCuenta = $cuenta->codigocuenta;
        $CuentaPeriodoFin = Cuentageneral::select(['saldo'])
                                        ->where('idempresa', '=', $idEmpresa)
                                        ->where('year', '=',  $periodoFin)
                                        ->where('codigocuenta', '=', $codigoCuenta)
                                        ->get();

    
        // array_push($cuentasBalance, $balanceG);

        if(!$CuentaPeriodoFin->isEmpty()){

                $nombreCuenta = Catalogo::select(['nombrecuenta'])
                                        ->where('idempresa', '=', $idEmpresa)
                                        ->where('codigocuenta', '=', $codigoCuenta)
                                        ->get();

            $saldoA = $cuenta->saldo;  
            $saldoB = $CuentaPeriodoFin[0]->saldo;     

            $analisisVertical->nombreCuenta = $nombreCuenta[0]->nombrecuenta;
            $analisisVertical->saldoPeriodoInicio = $saldoA;
            $analisisVertical->saldoPeriodoFin = $saldoB;
            $analisisVertical->bariacionAbsoluta = round(100*($saldoA/$activoTotal_ventaN_PeriodoInicio), 2);//No le pertenece el campo, pero su utlizara para gaurdar el analisis del año inicial
            $analisisVertical->bariacionRelativa = round(100*($saldoB/$activoTotal_ventaN_PeriodoFin), 2);//Analisis V año inicio
            $analisisVertical->idTipoCuenta = $cuenta->idtipocuenta;

            array_push($arrayElementosAnalisisV, $analisisVertical);

         }                                    

    }
// dd($arrayElementosAnalisisH);
return $arrayElementosAnalisisV;
}
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------
  public function getSaldoCuentaActivoTotal($idEmpresa, $periodoContable, $codCuentaRatio){
    $cuentaRatio = Cuentapuente::select(['codigocuenta'])->where('idempresa', '=', $idEmpresa)
                                                          ->where('year', '=', $periodoContable)
                                                          ->where('codcuentaratio', '=', $codCuentaRatio)
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

}

class AnalisisHVcontroller extends Controller
{
    //AnalisisHorizontalView

    public function analisisHorizontalGet($idEmpresa){

        $arrayAnalisisH = array();
        $error = FALSE;
        $peticionGet = FALSE;
        $periodosContable = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();

        $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
        $nomEmpresa = $nombreEmpresa[0]->nombreempresa;

        return view('AnalisisHorizontalView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'error', 'peticionGet', 'arrayAnalisisH'));

    }

   
    public function analisisVerticallGet($idEmpresa){

        $arrayAnalisisH = array();
        $error = FALSE;
        $peticionGet = FALSE;
        $periodosContable = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();

        $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
        $nomEmpresa = $nombreEmpresa[0]->nombreempresa;

        return view('AnalisisVerticalView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'error', 'peticionGet', 'arrayAnalisisH'));

    }

    public function analisisHorizontalPost(Request $request){

        $arrayAnalisisH = array();
        //dd($request);
        $arrayTipoCuenta = Tipocuentum::all();
        
        $error = FALSE;
        $peticionGet = TRUE;
       $periodoInicio = $request->periodoContableA;
       $periodoFin = $request->periodoContableB; 
       $idTipoEstadoFinanciero = $request->balance;

        $idEmpresa = $request->idEmpresa;

        $periodosContable = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();

        $ArrayPeriodosContableInicio = Cuentageneral::select(['codigocuenta'])->where('idempresa', '=', $idEmpresa)
                                         ->where('year', '=', $periodoInicio)
                                         ->where('idtipoestadofinanciero', '=', $idTipoEstadoFinanciero)
                                         ->get();

        $ArrayPeriodosContableFin = Cuentageneral::select(['codigocuenta'])->where('idempresa', '=', $idEmpresa)
                                                    ->where('year', '=', $periodoFin)
                                                    ->where('idtipoestadofinanciero', '=', $idTipoEstadoFinanciero)
                                                    ->get();                                 



        $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
        $nomEmpresa = $nombreEmpresa[0]->nombreempresa;


        if($periodoInicio >= $periodoFin){
            $error = TRUE;
            Alert::error('Error en el periodo', 'Periodo inicio tiene que ser mayor');
            return view('AnalisisHorizontalView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'error', 'peticionGet', 'arrayAnalisisH'));
        }

        if($ArrayPeriodosContableInicio->isEmpty() || $ArrayPeriodosContableFin->isEmpty()){
            $error = TRUE;
            Alert::error('Error registros no encontrados', 'Uno o ambos periodos no tiene registros');
            return view('AnalisisHorizontalView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'error', 'peticionGet', 'arrayAnalisisH'));
        }
        

     $analisHorizontal = new AnalisisVH();   
     
     $arrayAnalisisH = $analisHorizontal->analisisHorizontal($idEmpresa, $idTipoEstadoFinanciero, $periodoInicio, $periodoFin);

    return view('AnalisisHorizontalView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'error', 'peticionGet', 'arrayAnalisisH', 'periodoInicio', 'periodoFin', 'arrayTipoCuenta'));

    }

    //-----------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------
    //----------------------------------
    public function analisisVerticallPost(Request $request){

        $arrayAnalisisH = array();
        //dd($request);
        $arrayTipoCuenta = Tipocuentum::all();
        
        $analisHorizontal = new AnalisisVH();   

        $error = FALSE;
        $peticionGet = TRUE;
       $periodoInicio = $request->periodoContableA;
       $periodoFin = $request->periodoContableB; 
       $idTipoEstadoFinanciero = $request->balance;

        $idEmpresa = $request->idEmpresa;

        $periodosContable = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();

        $ArrayPeriodosContableInicio = Cuentageneral::select(['codigocuenta'])->where('idempresa', '=', $idEmpresa)
                                         ->where('year', '=', $periodoInicio)
                                         ->where('idtipoestadofinanciero', '=', $idTipoEstadoFinanciero)
                                         ->get();

        $ArrayPeriodosContableFin = Cuentageneral::select(['codigocuenta'])->where('idempresa', '=', $idEmpresa)
                                                    ->where('year', '=', $periodoFin)
                                                    ->where('idtipoestadofinanciero', '=', $idTipoEstadoFinanciero)
          
                                                    ->get();                                 
       
        
        $activoT_ventaN_peridoInicio = -1;
        $activoT_ventaN_peridoFin = -1;

        if($idTipoEstadoFinanciero == 1){

            $activoT_ventaN_peridoInicio = $analisHorizontal->getSaldoCuentaActivoTotal($idEmpresa, $periodoInicio, 'VI');
            $activoT_ventaN_peridoFin = $analisHorizontal->getSaldoCuentaActivoTotal($idEmpresa, $periodoFin, 'VI');
            if($activoT_ventaN_peridoInicio == -1){
                $error = TRUE;
                Alert::error('Error en el periodo '. $periodoInicio, 'Cuenta Ativo total sin registro');
                return view('AnalisisVerticalView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'error', 'peticionGet', 'arrayAnalisisH'));
            }
    
            if($activoT_ventaN_peridoFin == -1){
                $error = TRUE;
                Alert::error('Error en el periodo '. $periodoFin, 'Cuenta Ativo total sin registro');
                return view('AnalisisVerticalView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'error', 'peticionGet', 'arrayAnalisisH'));
            }
    
        }
        else{
            $activoT_ventaN_peridoInicio = $analisHorizontal->getSaldoCuentaActivoTotal($idEmpresa, $periodoInicio, 'IX');
            $activoT_ventaN_peridoFin = $analisHorizontal->getSaldoCuentaActivoTotal($idEmpresa, $periodoFin, 'IX');
            //dd($activoT_ventaN_peridoInicio."  ".$activoT_ventaN_peridoFin);
            if($activoT_ventaN_peridoInicio == -1){
                $error = TRUE;
                Alert::error('Error en el periodo '. $periodoInicio, 'Cuenta Venta Neta sin registro');
                return view('AnalisisVerticalView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'error', 'peticionGet', 'arrayAnalisisH'));
            }
    
            if($activoT_ventaN_peridoFin == -1){
                $error = TRUE;
                Alert::error('Error en el periodo '. $periodoFin, 'Cuenta Venta Neta sin registro');
                return view('AnalisisVerticalView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'error', 'peticionGet', 'arrayAnalisisH'));
            }
        }

        $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
        $nomEmpresa = $nombreEmpresa[0]->nombreempresa;

       

        if($periodoInicio >= $periodoFin){
            $error = TRUE;
            Alert::error('Error en el periodo', 'Periodo inicio tiene que ser mayor');
            return view('AnalisisVerticalView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'error', 'peticionGet', 'arrayAnalisisH'));
        }

        if($ArrayPeriodosContableInicio->isEmpty() || $ArrayPeriodosContableFin->isEmpty()){
            $error = TRUE;
            Alert::error('Error registros no encontrados', 'Uno o ambos periodos no tiene registros');
            return view('AnalisisVerticalView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'error', 'peticionGet', 'arrayAnalisisH'));
        }
        
        //se utiliza el mismo nombre de variable para no modificar la vista
        $arrayAnalisisH = $analisHorizontal->analisisVeritical($idEmpresa, $idTipoEstadoFinanciero, $periodoInicio, $periodoFin, $activoT_ventaN_peridoInicio, $activoT_ventaN_peridoFin);

    return view('AnalisisVerticalView', compact('idEmpresa', 'nomEmpresa', 'periodosContable', 'error', 'peticionGet', 'arrayAnalisisH', 'periodoInicio', 'periodoFin', 'arrayTipoCuenta'));

    }
    //------------------------------------------------------------------------------------
    //----------------------------------------------------------------
    //------------
}
