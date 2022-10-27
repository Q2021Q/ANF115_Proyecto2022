<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cuentageneral;//Modelo, para CURD de la tabla cuentageneral

use App\Models\Catalogo;//Modelo, para CURD de la empresa

use App\Http\Controllers\Funciones;



class BalanceG
{
    // Declaración de una propiedad
    protected $idControlError; //atributo para detectar errores


    protected $codigoCuenta;
    protected $tipoCuenta;
    protected $nombreCuenta;
    protected $saldoCuenta;
    protected $codigoCuentaRatio;


    public function get_idControlError(){
        return $this->idControlError;
     }
     public function set_idControlError($idControlError){
        $this->idControlError = $idControlError;
     }

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

    public  function extraerCuentaSinRegistro_Catalog($cuentaBalance): array{

    $codigoCuentaBalance = array();    
            for ( $j = 0; $j < count($cuentaBalance); $j = $j + 1 ) {
                $codigoCuentaBalance[$j] = $cuentaBalance[$j]->get_codigoCuenta();
            }

            $arrayCuentaSinRegistro = array();
            foreach($codigoCuentaBalance as $indice => $elemento) {
             $consultaCatalo = Catalogo::where('codigocuenta', '=',$elemento)->get();
             //   echo $consultaCatalo;
                if ($consultaCatalo->isEmpty()) {
                    $arrayCuentaSinRegistro[$indice] = $elemento;
                   // echo "*_";
                }
            }

        return $arrayCuentaSinRegistro;
         }      

}

class CuentaGeneralController extends Controller
{
    public function  importarBalanceGeneral(){
        return view('importarBalanceGeneralView');
    }

    public function importarBalance(Request $request){

        $cuentaGeneral = new Cuentageneral();

        
        $cuentasBalance = array();

        $BalanceGeneral = $request->balance;  
        
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
                            $balanceG->set_tipoCuenta($datos[$c]);//
                            // echo $datos[$c] . "<br />\n";
                            break;
                        case 2:
                            $balanceG->set_nombreCuenta($datos[$c]);
                           // echo $datos[$c] . "<br />\n";
                            break;
                        case 3:
                            $balanceG->set_saldoCuenta($datos[$c]);
                           // echo $datos[$c] . "<br />\n";
                            break;
                        case 4:
                            if($datos[$c] == NULL)
                                 $balanceG->set_codigoCuentaRatio("No");
                            else 
                                 $balanceG->set_codigoCuentaRatio($datos[$c]);    
                               // echo $datos[$c] . "<br />\n";
                             break;    
                    }
                    
                }
            array_push($cuentasBalance, $balanceG);
            }
            fclose($balance);
        }

        
        $balance = new BalanceG();
        $cuentas_repetidas = $balance->extraerCuentasRepetidasBalance($cuentasBalance);
       // dd($cuentas_repetidas);

       $mensaje = "Cargado con exito";
       $error_cuenta = FALSE;
//--------------------------------------------------------------------------------------------------------------
       $cuentasInvalidas = $cuentas_repetidas;
       if(empty(!$cuentas_repetidas)){
        $mensaje = "Error en el condigo de cuenta, los codigos deben ser unicos";
        $error_cuenta = TRUE;      
        return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta'));
       }
//--------------------------------------------------------------------------------------------------------------
       $cuentas_sinRegistro = $balance->extraerCuentaSinRegistro_Catalog($cuentasBalance);
       $cuentasInvalidas = $cuentas_sinRegistro;
       if(empty(!$cuentas_sinRegistro)){
        $mensaje = "Error en el codigo de cuenta, no se encontro uno o varios registro en el catalogo";
        $error_cuenta = TRUE;
        return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta'));
        //dd($cuentas_sinRegistro);
       }
//-----------------------------------------------------------------------------------------------------------------      
//Si no hay errores en las cuentas
    return view('BalanceImportadoView', compact('cuentasBalance', 'cuentasInvalidas', 'mensaje', 'error_cuenta'));

     //return view('BalanceImportadoView', compact('cuentasBalance', 'cuentas_repetidas', 'mensaje', 'error_cuenta'));
     // return "Guardado con exito";
    //  dd($cuentasBalance);
     // return $cuentasBalance;

     
    }

   public function index(){
        $datos = Cuentageneral::all();

        $puntos = [];
        foreach($datos as $dato){
            $puntos[] = ['name' => $dato['CODIGOCUENTA'], 'y' => floatval($dato['SALDO'])];
        }
        return view("Graficos", ["data" => json_encode($puntos)]);
   }
    
}
