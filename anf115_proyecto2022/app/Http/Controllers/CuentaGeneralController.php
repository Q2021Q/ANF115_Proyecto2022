<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cuentageneral;//Modelo, para CURD de la tabla cuentageneral

//Bariables globales
global $cuentasBalance;

class BalanceG
{
    // Declaración de una propiedad
    protected $codigoCuenta;
    protected $tipoCuenta;
    protected $nombreCuenta;
    protected $saldoCuenta;
    protected $codigoCuentaRatio;

    protected $cuentaList = array();



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


     public function get_cuentaList(){
        return $this->cuentaList;
     }
     public function set_cuentaList($cuentaList){
        $this->cuentaList = $cuentaList;
     }


     public  function extraerCuentasRepetidasBalance($cuentaBalance){

        $cuentasBalanceRepetida = array();

        $cuentaBalance->get_cuentaList();

        foreach ($cuentaBalance as $balance) {
            $codBalance = $balance->get_codigoCuenta();
            foreach ($cuentaBalance as $balance) {
            
                if($codBalance == $balance->get_codigoCuenta()) {

                    $cuentas_repetidas_balance = new BalanceG();
                    $cuentas_repetidas_balance->set_codigoCuenta($balance->get_codigoCuenta());
                    array_push($cuentasBalanceRepetida, $cuentas_repetidas_balance);
                }

            }

        }
         return $cuentasBalanceRepetida;
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
                            $balanceG->set_codigoCuenta($datos[$c]);//
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

        // $balance = new BalanceG();
        // $balance->set_cuentaList($cuentasBalance);
        // $balance->extraerCuentasRepetidasBalance($balance);
        // dd($balance_buscarCuentasRepetidas);
     return view('BalanceImportadoView', compact('cuentasBalance'));
     // return "Guardado con exito";
    //  dd($cuentasBalance);
     // return $cuentasBalance;

     
    }

   
    
}
