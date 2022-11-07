<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Periodocontable;
use App\Models\Empresa;
use App\Models\Catalogo;
use Illuminate\Support\Facades\DB;

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

    

    public function get_nombreCuenta(){
        return $this->nombreCuenta;
     }
     public function set_nombreCuenta($nombreCuenta){
        $this->nombreCuenta = $nombreCuenta;
     }


     public function get_codigoCuentaRatio(){
        return $this->codigoCuentaRatio;
     }
     public function set_codigoCuentaRatio($codigoCuentaRatio){
        $this->codigoCuentaRatio = $codigoCuentaRatio;
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
                        $balanceG->set_nombreCuenta(trim($datos[$c], ' ;*,'));
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


//*************************************************************************************************************************************************** */

public  function extraerCuentasRepetidasCatalogo($cuentaBalance): array{

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

//****************************************************************************************************************************************************** */

public  function getCuentasCatalogoExistente($arrayCuentaCatalogo, $idempresa): array{  

    $arrayCuentaCatalogolExistenteBD = array();

    for ( $j = 0; $j < count($arrayCuentaCatalogo); $j = $j + 1 ) { 

        $codigoCuenta = $arrayCuentaCatalogo[$j]->get_codigoCuenta();
       
       $cuentaCatalogo = Catalogo::where('codigocuenta' , '=', $codigoCuenta)
                                     ->where('idempresa', '=', $idempresa)->get();

             if (!$cuentaCatalogo->isEmpty()) {
                $arrayCuentaCatalogolExistenteBD[$j] = $codigoCuenta;
                 //echo "--*--";
            }
    }   
    return $arrayCuentaCatalogolExistenteBD;
}

//-------------------------------------------------------- ----------------------------------------------------------------------------------------------*/
                                                  //$cuentaBalance
public  function extraerCuentasVaciasCatalogoImport($cuentasCatalogo): array{

    $arryCuentasImportCatalogo = array();    
         for ( $j = 0; $j < count($cuentasCatalogo); $j = $j + 1 ) {
            $cuentaCatalogo = $cuentasCatalogo[$j]->get_codigoCuenta();
            $arryCuentasImportCatalogo[$j] =  $cuentaCatalogo;
          }
    
          $arryCuentasVaciasImport = array();
            foreach($arryCuentasImportCatalogo as $indice => $elemento) {
                if ($elemento == ".") {
                    $arryCuentasVaciasImport[$indice] = $elemento;
                        //echo "*_";
                }
    }
    //Retorna array de nombres de cuentas vaicas de catalog
    //NOTA es codigo resiclado de otro metodo 
     return $arryCuentasVaciasImport;
}

public  function extraerNombreCuentasVaciasCatalogoImport($cuentasCatalogo): array{

    $arryCuentasImportCatalogo = array();    
         for ( $j = 0; $j < count($cuentasCatalogo); $j = $j + 1 ) {
            $cuentaCatalogo = $cuentasCatalogo[$j]->get_nombreCuenta();
            $arryCuentasImportCatalogo[$j] =  $cuentaCatalogo;
          }
    
          $arryCuentasVaciasImport = array();
            foreach($arryCuentasImportCatalogo as $indice => $elemento) {
                if (empty($elemento)) {
                    $arryCuentasVaciasImport[$indice] = $elemento;
                        //echo "*_";
                }
    }
    
     return $arryCuentasVaciasImport;
}



//--------------------------------------------------------------------------------------------------------------------------------------------------------

}



class CatalogoImportController extends Controller
{
    public function importarCatalogoCSV(Request $request){
        
        $idEmpresa = $request->idEmpresa;
        $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
        $nomE = $nombreEmpresa[0]->nombreempresa;

        $idEmpresa = $request->idEmpresa;

       // $cuentaGeneral = new Cuentageneral();
       $cataloto = new Catalogo();
        
        $balance = new BalanceG();
        $BalanceGeneral = $request->balance;  
        // dd($cuentas_repetidas);
        $cuentasBalance = $balance->extraerElementosArchivo_CSV($BalanceGeneral);

        $cuentasBalance = $balance->setReasignarCamposVacios_finla($cuentasBalance);
        $mensaje = "Cargado con exito";
        $error_cuenta = FALSE;

//-----------------------------------------------------------------------------------------------------------------------------
        $cuentas_repetidas = $balance->extraerCuentasRepetidasCatalogo($cuentasBalance);
        $cuentasInvalidas = $cuentas_repetidas;
        if(empty(!$cuentas_repetidas)){
        $mensaje = "Error en el condigo de cuenta, los codigos deben ser unicos";
        $error_cuenta = TRUE;      
        return view('CatalogoImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta', 'nomE'));
        }

       // return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta'));
//******************************************************************************************************************************

        $CuentasGeneralExistente = $balance->getCuentasCatalogoExistente($cuentasBalance, $idEmpresa);
        $cuentasInvalidas = $CuentasGeneralExistente;
        if(empty(!$CuentasGeneralExistente)){
            $mensaje = "¡ Intenta ingresar cuentas ya existentes !, revise el archivo porfavor";
            $error_cuenta = TRUE;   
            
            return view('CatalogoImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta', 'nomE'));
        }
   
 //----------------------------------------------------------------------------------------------------------------------------
 
 $arrayCuentasInvalidos = $balance->extraerCuentasVaciasCatalogoImport($cuentasBalance);
 $cuentasInvalidas = $arrayCuentasInvalidos;
 if(empty(!$arrayCuentasInvalidos)){
    $mensaje = "Error en el codigo de la cuenta, el campo es obligatorio";
    $error_cuenta = TRUE;   
    
    return view('CatalogoImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta', 'nomE'));
   }

   //------------------------------------------------------------------------------------------------------------------------------
   $NombreCuentasVaciasCatalogo = $balance->extraerNombreCuentasVaciasCatalogoImport($cuentasBalance);
   $cuentasInvalidas = $NombreCuentasVaciasCatalogo;
   if(empty(! $NombreCuentasVaciasCatalogo)){
      $mensaje = "Error en el nombre de la cuenta, el campo es obligatorio";
      $error_cuenta = TRUE;   
      
      return view('CatalogoImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta', 'nomE'));
   }
//-----------------------------------------------------------------------------------------------------------------------------

try{
    DB::transaction(function () use ($cuentasBalance, $request){
        
        foreach($cuentasBalance as $elemento) { 
            //cuentaGeneral
            $catalogo = new Catalogo();
            $catalogo->codigocuenta = $elemento->get_codigoCuenta();
            $catalogo->idempresa = $request->idEmpresa;
            $catalogo->nombrecuenta = $elemento->get_nombreCuenta();
        // echo "*-*-";
            $catalogo->save();  

        }    

    });

    


} catch (\Exception $e) {
return response()->json(['message' => 'Error']);
}

//-----------------------------------------------------------------------------------------------------------------------------
        return view('CatalogoImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta', 'nomE'));
    }
//---------------------------------------------------------------------------------------------------------------------------

    public function importarCatalogo($idEmpresa){

            
     try {
        
            $arrayPeriodos = array();

            $periodosContables = Periodocontable::select(['year'])->where('idempresa', '=', $idEmpresa)->get();
            $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();

            $nameEmpresa = $nombreEmpresa[0]->nombreempresa;

            foreach($periodosContables as $periodo){
                array_push($arrayPeriodos, $periodo->year);
            }
   

    
    } catch (\Exception $e) {
       
        $listEmpresa = Empresa::all();
      //  return view('EmpresaHome', compact('listEmpresa'));
    }
        return view('importarCatalogoView', compact('arrayPeriodos','idEmpresa', 'nameEmpresa'));

    }
  }
