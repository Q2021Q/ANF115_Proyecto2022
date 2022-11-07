<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Models\Cuentageneral;//Modelo, para CURD de la tabla cuentageneral

use App\Models\Catalogo;//Modelo, para CURD de la Catalogo

use App\Models\Cuentaratio;//Modelo, para CURD en la tabla Cuentaratio
use App\Models\Tipocuentum;
use App\Models\Periodocontable;
use App\Models\Cuentapuente;
use App\Models\Empresa;


use App\views\importarBalanceGeneralView;
use App\views\ImportarEstadoResultadoView;

use RealRashid\SweetAlert\Facades\Alert;




class BalanceG
{
    // Declaración de una propiedad
    

    protected $codigoCuenta;
    protected $tipoCuenta;
    protected $nombreCuenta;
    protected $saldoCuenta;
    protected $codigoCuentaRatio;

    protected $nombreCuentaRatio;
    protected $nombreTipoCuenta;
    




    public function get_codigoCuenta(){
        return $this->codigoCuenta;
     }
     public function set_codigoCuenta($codigoCuenta){
        $this->codigoCuenta = $codigoCuenta;
     }

     public function get_tipoCuenta(){
        return $this->tipoCuenta;
     }
     public function set_tipoCuenta($tipoCuenta){
        $this->tipoCuenta = $tipoCuenta;
     }

    public function get_nombreCuenta(){
        return $this->nombreCuenta;
     }
     public function set_nombreCuenta($nombreCuenta){
        $this->nombreCuenta = $nombreCuenta;
     }

     public function get_saldoCuenta(){
        return $this->saldoCuenta;
     }
     public function set_saldoCuenta($saldoCuenta){
        $this->saldoCuenta = $saldoCuenta;
     }

     public function get_codigoCuentaRatio(){
        return $this->codigoCuentaRatio;
     }
     public function set_codigoCuentaRatio($codigoCuentaRatio){
        $this->codigoCuentaRatio = $codigoCuentaRatio;
     }

     public function get_nombreCuentaRatio(){
        return $this->nombreCuentaRatio;
     }
     public function set_nombreCuentaRatio($nombreCuentaRatio){
        $this->nombreCuentaRatio = $nombreCuentaRatio;
     }

     public function get_nombreTipoCuenta(){
        return $this->nombreTipoCuenta;
     }
     public function set_nombreTipoCuenta($nombreTipoCuenta){
        $this->nombreTipoCuenta = $nombreTipoCuenta;
     }


     public  function extraerCuentasRepetidasBalance($cuentaBalance): array{

        $codigoCuentaBalance = array();    
        for ( $j = 0; $j < count($cuentaBalance); $j = $j + 1 ) {
            $codigoCuentaBalance[$j] = $cuentaBalance[$j]->get_codigoCuenta();
        }
    
            $arraySinDuplicados = array();
            foreach($codigoCuentaBalance as $indice => $elemento) {
                if (!in_array($elemento, $arraySinDuplicados)) {
                    $arraySinDuplicados[$indice] = $elemento;
                }
            }
           
            $cuentasRepetidas = [];   
            foreach($arraySinDuplicados as $indi => $elemen) {

                $contador = 0;
                for ( $l = 0; $l < count($cuentaBalance); $l = $l + 1 ) {
                   if($elemen == $cuentaBalance[$l]->get_codigoCuenta()) {
                    $contador = $contador + 1;
                    //echo "  *    ";
                   }
                } 
              //  echo "  *    ";
                if($contador > 1){
                    $cuentasRepetidas[$indi] = $elemen;
                }
            }      


            // return $codigoCuentaBalance;
            return $cuentasRepetidas;
    }
//---------------------------------------------------------------------------------------------------------------------------
public  function extraerCuentasDuplicasdadRatio($cuentaBalance): array{

    $arrayCodigoCuetasRatio = array();    
    for ( $j = 0; $j < count($cuentaBalance); $j = $j + 1 ) {
        $arrayCodigoCuetasRatio[$j] = $cuentaBalance[$j]->get_codigoCuentaRatio();
    }

        $arraySinDuplicados = array();
        foreach($arrayCodigoCuetasRatio as $indice => $elemento) {
            if (!in_array($elemento, $arraySinDuplicados)) {
                $arraySinDuplicados[$indice] = $elemento;
            }
        }
       
        $cuentasRepetidas = [];   
        foreach($arraySinDuplicados as $indi => $elemen) {

            $contador = 0;
            for ( $l = 0; $l < count($cuentaBalance); $l = $l + 1 ) {
               if($elemen == $cuentaBalance[$l]->get_codigoCuentaRatio()) {
                $contador = $contador + 1;
                //echo "  *    ";
               }
            } 
          //  echo "  *    ";
            if($contador > 1){
                $cuentasRepetidas[$indi] = $elemen;
            }
        }      


        // return $codigoCuentaBalance;
        return $cuentasRepetidas;
     }

         

    public  function extraerCuentaSinRegistro_Catalog($cuentaBalance, $idEmpresa): array{

    $codigoCuentaBalance = array();    
            for ( $j = 0; $j < count($cuentaBalance); $j = $j + 1 ) {
                $codigoCuentaBalance[$j] = $cuentaBalance[$j]->get_codigoCuenta();
            }

            $arrayCuentaSinRegistro = array();
            foreach($codigoCuentaBalance as $indice => $elemento) {
             $consultaCatalo = Catalogo::where('codigocuenta', '=',$elemento)
                                       ->where('idempresa', '=', $idEmpresa)->get();
             //   echo $consultaCatalo;
                if ($consultaCatalo->isEmpty()) {
                    $arrayCuentaSinRegistro[$indice] = $elemento;
                  // echo "*_";
                }
            }

        return $arrayCuentaSinRegistro;
         }      

    public  function extraerCuentaSinRegistro_cuentaRatio($cuentaBalance): array{

        $arryCodigotaRatio = array();    
             for ( $j = 0; $j < count($cuentaBalance); $j = $j + 1 ) {
                $codigo_cRatio = $cuentaBalance[$j]->get_codigoCuentaRatio();
                if(!empty($codigo_cRatio)){
                    $arryCodigotaRatio[$j] =  $codigo_cRatio;
                }
               
              }
        
                $arrayRatioSinRegistro = array();
                foreach( $arryCodigotaRatio as $indice => $elemento) {
                    $consultaRatio = Cuentaratio::where('codcuentaratio', '=',$elemento)->get();
                       //echo  $consultaRatio;
                    if ($consultaRatio->isEmpty()) {
                        $arrayRatioSinRegistro[$indice] = $elemento;
                            //echo "*_";
                    }
        }
        
    return $arrayRatioSinRegistro;
} 

//--------------------------------------------------------------------------------------------------------------------------
public  function extraerCuentaSinRegistro_tipoCuenta($cuentaBalance): array{

    $arryIdTipoCuenta = array();    
         for ( $j = 0; $j < count($cuentaBalance); $j = $j + 1 ) {
            $idTipoCuenta = $cuentaBalance[$j]->get_tipoCuenta();
                $arryIdTipoCuenta[$j] =  $idTipoCuenta;
          }
    
            $arrayIdTipoCuentaSinRegistro = array();
            foreach( $arryIdTipoCuenta as $indice => $elemento) {
                $consultaTipoCuenta = Tipocuentum::where('idtipocuenta', '=',$elemento)->get();
                   //echo  $consultaRatio;
                if ($consultaTipoCuenta->isEmpty()) {
                    $arrayIdTipoCuentaSinRegistro[$indice] = $elemento;
                        //echo "*_";
                }
    }
    
 return $arrayIdTipoCuentaSinRegistro;
} 

//--------------------------------------------------------------------------------------------------------------------------------------
public  function extraerCuentaSaldosInvalidosImport($cuentaBalance): array{

    $arryCuentasImportSaldos = array();    
         for ( $j = 0; $j < count($cuentaBalance); $j = $j + 1 ) {
            $saldoCuenta = $cuentaBalance[$j]->get_saldoCuenta();
            $arryCuentasImportSaldos[$j] =  $saldoCuenta;
          }
    
          $arryCuentasInvalidasImport = array();
            foreach($arryCuentasImportSaldos as $indice => $elemento) {
                if (!is_numeric($elemento)) {
                    $arryCuentasInvalidasImport[$indice] = $elemento;
                        //echo "*_";
                }
    }
    
     return $arryCuentasInvalidasImport;
}
 
 public  function setNombreCuentaRatio($cuentaBalance): array{   
    foreach($cuentaBalance as $elemento) { 
        $codigo_cRatio = $elemento->get_codigoCuentaRatio();
        // echo $codigo_cRatio;
            if(!empty($codigo_cRatio)){
                $consultaRatio = Cuentaratio::select(['nombrecuentaratio'])->where('codcuentaratio', '=',$codigo_cRatio)->get();
                // echo $consultaRatio;
                if (!$consultaRatio->isEmpty()) {
                    foreach($consultaRatio as $consultaNombre) {
                        $elemento->set_nombreCuentaRatio($consultaNombre->nombrecuentaratio);
                        // echo $elemento->nombrecuentaratio;
                            //dd($elemento->CODCUENTARATIO);
                        }
                }
                else
                    $elemento->set_nombreCuentaRatio($codigo_cRatio);
            }
            
    }   
    return $cuentaBalance;
 }

 public  function setNombreTipoCuenta($cuentaBalance): array{   
    foreach($cuentaBalance as $elemento) { 
        $idTipoCuenta = $elemento->get_tipoCuenta();
        // echo $codigo_cRatio;
                $consultaTipoCuenta = Tipocuentum::select(['nomtipocuenta'])->where('idtipocuenta', '=', $idTipoCuenta)->get();
                // echo $consultaRatio;
                if (!$consultaTipoCuenta->isEmpty()) {
                    foreach($consultaTipoCuenta as $consultaNombre) {
                        $elemento->set_nombreTipoCuenta($consultaNombre->nomtipocuenta);
                        // echo $elemento->nombrecuentaratio;
                            //dd($elemento->CODCUENTARATIO);
                        }
                }
                else
                 $elemento->set_nombreTipoCuenta($idTipoCuenta);
            
    }   
    return $cuentaBalance;
 }

 public  function setReasignarCamposVacios_finla($cuentaBalance): array{   
    foreach($cuentaBalance as $elemento) { 
        $idTipoCuenta = $elemento->get_codigoCuenta();

             if (empty($idTipoCuenta)) {
                 $elemento->set_codigoCuenta(".");//solo para que la vista lusca una fila con las mismas dimenciones que el reto de filas
                 //echo "--*--";
            }
    }   
    return $cuentaBalance;
}
//---------------------------------------------------------------------------------------------------------------------------
// ++++++++++++++++++++++++++++++++
// --------------------------------

public  function getCuentasExistenteCuentaPunte($cuentaBalance, $year, $idempresa): array{  

    $arrayCuentaPuenteExistenteBD = array();

    for ( $j = 0; $j < count($cuentaBalance); $j = $j + 1 ) { 

        $codigoCuenta = $cuentaBalance[$j]->get_codigoCuenta();
        $codcuentaratio = $cuentaBalance[$j]->get_codigoCuentaRatio();
       
       $cuentaPuente = Cuentapuente::where('codigocuenta' , '=', $codigoCuenta)
                                   ->where('codcuentaratio', '=', $codcuentaratio)
                                   ->where('year', '=', $year)
                                   ->where('idempresa', '=', $idempresa)->get();

             if (!$cuentaPuente->isEmpty()) {
                $arrayCuentaPuenteExistenteBD[$j] = $codigoCuenta;
                 //echo "--*--";
            }
    }   
    return $arrayCuentaPuenteExistenteBD;
}


public  function getCuentasGeneralExistente($cuentaBalance, $year, $idempresa): array{  

    $arrayCuentaGeneralExistenteBD = array();

    for ( $j = 0; $j < count($cuentaBalance); $j = $j + 1 ) { 

        $codigoCuenta = $cuentaBalance[$j]->get_codigoCuenta();
       
       $cuentaGeneral = Cuentageneral::where('codigocuenta' , '=', $codigoCuenta)
                                   ->where('year', '=', $year)
                                   ->where('idempresa', '=', $idempresa)->get();

             if (!$cuentaGeneral->isEmpty()) {
                $arrayCuentaGeneralExistenteBD[$j] = $codigoCuenta;
                 //echo "--*--";
            }
    }   
    return $arrayCuentaGeneralExistenteBD;
}

//******************************************************************************************************************** */
public function extraerElementosArchivo_CSV($BalanceGeneral): array{

    $cuentasBalance = array();
    
    $fila = 1;
    if (($balance = fopen($BalanceGeneral,"r")) !== FALSE) {
        while (($datos = fgetcsv($balance, 1000, ",")) !== FALSE) {

            $balanceG = new BalanceG();

            $numero = count($datos);

           
           // echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
            $fila++;
            for ($c=0; $c < $numero; $c++) {
                switch ($c) {
                    case 0:
                        $balanceG->set_codigoCuenta(trim($datos[$c], ' ;*,'));//
                       // echo $datos[$c] . "<br />\n";
                        break;
                    case 1:
                        $balanceG->set_tipoCuenta(trim($datos[$c], ' ;*,'));//
                        // echo $datos[$c] . "<br />\n";
                        break;
                    case 2:
                        $balanceG->set_nombreCuenta(trim($datos[$c], ' ;*,'));
                       // echo $datos[$c] . "<br />\n";
                        break;
                    case 3:
                        $balanceG->set_saldoCuenta(trim($datos[$c], ' ;*,'));
                       // echo $datos[$c] . "<br />\n";
                        break;
                    case 4:
                        if($datos[$c] == NULL)
                             $balanceG->set_codigoCuentaRatio("No");
                        else 
                             $balanceG->set_codigoCuentaRatio(trim($datos[$c], ' ;*,'));    
                           // echo $datos[$c] . "<br />\n";
                         break;    
                }
                
            }
        array_push($cuentasBalance, $balanceG);
        }
        fclose($balance);
    }
return $cuentasBalance;
}
//************************************************************************************************************************************************** */

}

class CuentaGeneralController extends Controller
{
    public function  importarBalanceGeneral($idEmpresa){

try {
    
        $arrayPeriodos = array();

        $periodosContables = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();
        $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();

        $nameEmpresa = $nombreEmpresa[0]->nombreempresa;

        foreach($periodosContables as $periodo){
            array_push($arrayPeriodos, $periodo->year);
        }
        
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error']);
    }
    
        return view('importarBalanceGeneralView', compact('arrayPeriodos','idEmpresa', 'nameEmpresa'));
}
//--------------------------------------------------------------------------------------------------------------------
    public function importarBalance(Request $request){

        $idEmpresa = $request->idEmpresa;
        $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
        $nomE = $nombreEmpresa[0]->nombreempresa;
       //dd($request);

       $indicadorEstadoF = $request->indicadorTipoEF;
       $nombreEstado = "";
       if($indicadorEstadoF == 1)
            $nombreEstado = "Balance General";
        else
            $nombreEstado = "Estado de Resultados";

        $year = $request->periodoContable;
        $idEmpresa = $request->idEmpresa;

        $cuentaGeneral = new Cuentageneral();
        
        $balance = new BalanceG();
        $BalanceGeneral = $request->balance;  
       // dd($cuentas_repetidas);
       $cuentasBalance = $balance->extraerElementosArchivo_CSV($BalanceGeneral);
       $cuentasBalance = $balance->setNombreCuentaRatio($cuentasBalance);
       $cuentasBalance = $balance->setNombreTipoCuenta($cuentasBalance);
       $cuentasBalance = $balance->setReasignarCamposVacios_finla($cuentasBalance);
       $mensaje = "Cargado con exito";
       $error_cuenta = FALSE;

//validacion
//--------------------------------------------------------------------------------------------------------------
$cuentas_sinRegistro = $balance->extraerCuentaSinRegistro_Catalog($cuentasBalance, $idEmpresa);
$cuentasInvalidas = $cuentas_sinRegistro;
if(empty(!$cuentas_sinRegistro)){
  $mensaje = "No se encontro uno o varios registros en el catalogo";
    $error_cuenta = TRUE;
    //Hasta que ya se a utilizado para extraer los elementosn entonces reemplazar el codigo de la cuenta por el nombre de la cuenta de ratios
    //$BalanceImportadoView = $balance->asignarCuentaRatio_xKey($cuentasBalance);

    Alert::error('Error en los datos', 'Error en el codigo de cuenta');

    return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta','nomE', 'nombreEstado'));
        //dd($cuentas_sinRegistro);
}
    
  //validacion     
//-----------------------------------------------------------------------------------------------------------------      
$cuentas_repetidas = $balance->extraerCuentasRepetidasBalance($cuentasBalance);
$cuentasInvalidas = $cuentas_repetidas;
if(empty(!$cuentas_repetidas)){
 $mensaje = "Error en el condigo de cuenta";
 $error_cuenta = TRUE;  
 
 Alert::error('Error en los datos', 'Cuentas duplicadas');
 
 return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta','nomE', 'nombreEstado'));
}

  //Validacion  
//--------------------------------------------------------------------------------------------------------------

$cuentas_sinRegistro_ratios = $balance->extraerCuentaSinRegistro_cuentaRatio($cuentasBalance);
$cuentasInvalidas = $cuentas_sinRegistro_ratios;
if(empty(!$cuentas_sinRegistro_ratios)){
    $mensaje = "No existe la cuenta de ratio";
    $error_cuenta = TRUE;   
    Alert::error('Error en los datos', 'Cuenta Ratio sin registro');
     //Hasta que ya se a utilizado para extraer los elementosn entonces reemplazar el codigo de la cuenta por el nombre de la cuenta de ratios
    return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta','nomE', 'nombreEstado'));
   }

//-------------------------------------------------------------------------------------------------------------------------------
  $CuentasDuplicadasRatios = $balance->extraerCuentasDuplicasdadRatio($cuentasBalance); 
  $cuentasInvalidas = $CuentasDuplicadasRatios;
  if(empty(!$CuentasDuplicadasRatios)){
    $mensaje = "Error en el condigo de la cuenta ratio";
    $error_cuenta = TRUE;   
    Alert::error('Error en los datos', 'Codigo de ratio duplicado');
    return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta','nomE', 'nombreEstado'));
   }
//--------------------------------------------------------------------------------------------------------------------------------------

$cuentaSinRegistro_tipoCuenta = $balance->extraerCuentaSinRegistro_tipoCuenta($cuentasBalance);
$cuentasInvalidas = $cuentaSinRegistro_tipoCuenta;
if(empty(!$cuentaSinRegistro_tipoCuenta)){
    $mensaje = "Registros no encontrados";
    $error_cuenta = TRUE;   
    Alert::error('Error en los datos', 'Error en el id del tipo de cuenta');
    return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta','nomE', 'nombreEstado'));
   }
 //-------------------------------------------------------------------------------------------------------------------------------------
 
 $arraySaldosInvalidos = $balance->extraerCuentaSaldosInvalidosImport($cuentasBalance);
 $cuentasInvalidas = $arraySaldosInvalidos;
 if(empty(!$arraySaldosInvalidos)){
    $mensaje = "Error en el saldo de la cuenta";
    $error_cuenta = TRUE;   
    Alert::error('Error en los datos', 'Uno o mas saldos son invalidos');
    return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta','nomE', 'nombreEstado'));
   }
//Si no hay errores en las cuentas

//--------------------------------------------------------------------------------------------------------------------------------


$CuentasGeneralExistente = $balance->getCuentasGeneralExistente($cuentasBalance, $year, $idEmpresa);
$cuentasInvalidas = $CuentasGeneralExistente;
if(empty(!$CuentasGeneralExistente)){
    $mensaje = "¡ Intenta ingresar cuentas ya existentes !";
    Alert::error('Error en los datos', 'Intenta ingresar cuentas ya existentes !, revise el archivo porfavor');
    $error_cuenta = TRUE;   
    
    return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta','nomE', 'nombreEstado'));
   }

//------------------------------------------------------------------------------------------------------------------------------------------*/


$arrayCuentaPuenteDuplicacadaBD = $balance->getCuentasExistenteCuentaPunte($cuentasBalance, $year, $idEmpresa);
$cuentasInvalidas = $arrayCuentaPuenteDuplicacadaBD;
if(empty(!$arrayCuentaPuenteDuplicacadaBD)){
    $mensaje = "Cuenta de ratio registrada";
    $error_cuenta = TRUE;   
    Alert::error('Error en los datos', 'Intenta ingresar cuentas de razones financieras existentes');
    return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta','nomE', 'nombreEstado'));
   }
//-------------------------------------------------------------------------------------------------------------------------------

try {
    $indicadorEstadoFinanciero = $request->indicadorEstadoFinanciero;


     DB::transaction(function () use ($cuentasBalance, $request){
        foreach($cuentasBalance as $elemento) { 
            $cuentaGeneral = new Cuentageneral();
            $cuentaGeneral->codigocuenta = $elemento->get_codigoCuenta();
            $cuentaGeneral->idempresa = $request->idEmpresa;
            $cuentaGeneral->year = $request->periodoContable;
            $cuentaGeneral->idtipocuenta = $elemento->get_tipoCuenta();
            $cuentaGeneral->saldo = $elemento->get_saldoCuenta();
            $cuentaGeneral->idtipoestadofinanciero = $request->indicadorTipoEF;
           // echo "*-*-";
            $cuentaGeneral->save();

            if(empty(!($elemento->get_codigoCuentaRatio()))){
              $cuentaPuente = new Cuentapuente();
              $cuentaPuente->codcuentaratio = $elemento->get_codigoCuentaRatio();
              $cuentaPuente->year = $request->periodoContable;
              $cuentaPuente->idempresa = $request->idEmpresa;
              $cuentaPuente->codigocuenta = $elemento->get_codigoCuenta();
              $cuentaPuente->save();
            }
        } 

    });
   
} catch (\Exception $e) {
    return response()->json(['message' => 'Error']);
}

//--------------------------------------------------------------------------------------------------------------------------------- */

//return redirect()->route('importarBalance_Redirec', ['cuentasBalance1' => $cuentasBalance]);
//return redirect()->route('importarBalance_Redirec', $cuentasBalance, $cuentasInvalidas, $mensaje, $error_cuenta);
return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta','nomE', 'nombreEstado'));
     
}

public function  importarEstadoResultado($idEmpresa){

    try {
    
        $arrayPeriodos = array();

        $periodosContables = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();
        $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();

        $nameEmpresa = $nombreEmpresa[0]->nombreempresa;

        foreach($periodosContables as $periodo){
            array_push($arrayPeriodos, $periodo->year);
        }
        
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error']);
    }
    
        return view('ImportarEstadoResultadoView', compact('arrayPeriodos','idEmpresa', 'nameEmpresa'));

}
//**************************************************************************************************************************** */
 

public function importarBalanceRedirec($cuentasBalance): array{
    return "Exito";

}

/*-------------------------------------------------------------------------------------------------*/

public function graficosc($idEmpresa){
    $consultas = Cuentageneral::select(['year','saldo','idempresa'])
    ->where('idempresa',$idEmpresa)
    ->orderBy('year','asc')
    ->get();
    $periodosContable = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();
    $CodCatalogo = Catalogo::select(['nombrecuenta','codigocuenta'])
                                         ->where('idempresa', '=', $idEmpresa)
                                         ->get();
    $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
    $nameEmpresa = $nombreEmpresa[0]->nombreempresa;
    $puntos = [];
    foreach($consultas as $consulta){
        $puntos[] = ['name'=>$consulta['year'], 'y'=>floatval($consulta['saldo']),'idempresa'=>$idEmpresa,'nameEmpresa'=>$nameEmpresa];
    }
    return view("GraficoConsultas",compact('idEmpresa','nameEmpresa','consultas','periodosContable','CodCatalogo') ,["data" => json_encode($puntos)]);
    //dd($periodosContable);
}

public function graficosf(Request $request){
    $fechainicio = $request->input('fechainicio');
    $fechafin = $request->input('fechafin');
    $idEmpresa = $request->input('idEmpresa');
    $periodosContable = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();
    $consultas = Cuentageneral::select(['year','saldo','idEmpresa'])
    ->where('idEmpresa',$idEmpresa)
    ->whereBetween('year', [$fechainicio, $fechafin])
    ->orderBy('year','asc')
    ->get();
    
    $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idEmpresa', '=', $idEmpresa)->get();
    $nameEmpresa = $nombreEmpresa[0]->nombreempresa;
    $puntos = [];
    foreach($consultas as $consulta){
        $puntos[] = ['name'=>$consulta['year'], 'y'=>floatval($consulta['saldo']),'idEmpresa'=>$idEmpresa,'nameEmpresa'=>$nameEmpresa];
    }
    return view("graficos",compact('idEmpresa','nameEmpresa','consultas','periodosContable') ,["data" => json_encode($puntos)]);
    // dd($consultas);
    //return $request;
    //return view("graficos");
    //dd($request->all());
    //echo "Si se enviaron $fechainicio, $fechafin, $idEmpresa";
}

public function eloquent(Request $request){
    // //$arrayCuentaf = array();
    // $consulta = Cuentageneral::select(['year','saldo','idempresa'])
    //                         ->where('idempresa',$idEmpresa)
    //                         ->whereBetween('year',[$desde,$hasta])
    //                         ->orderBy('year')
    //                         ->get();
    // // $datos = [];
    // // foreach($consultas as $consulta){
    // //     $datos[] = ['name'=>$consulta['year'], 'y'=>$consulta['saldo']];
    // // }
    // // return $consulta->toArray();
    dd($request->all());
}
    
}
