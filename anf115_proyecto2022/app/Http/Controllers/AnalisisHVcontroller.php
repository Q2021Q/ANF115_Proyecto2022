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
}
