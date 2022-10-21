<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cuentageneral;//Modelo, para CURD de la tabla cuentageneral

class CuentaGeneralController extends Controller
{
    public function  importarBalanceGeneral(){
        return view('importarBalanceGeneralView');
    }

    public function importarBalance(Request $request){

        $BalanceGeneral = $request->archivo2;  
        $balance = fopen($BalanceGeneral,"r"); 

        //$b = fread($balance, filesize($BalanceGeneral));

       /* $lineNumber = 1;
        while (($raw_string = fgets($balance)) !== false) {
            $row = str_getcsv($raw_string);
            echo var_dump($row);
            $lineNumber++;
        }
        fclose($balance);*/

       
        while (($line = fgetcsv($balance)) !== FALSE) {
            echo '<pre>';
            print_r($line);
            echo '</pre>';
            }
        fclose($balance);


       // echo $b;
       /* $empresa = new Empresa;

      $empresa->idempresa = $request -> empresa;
      $empresa->idrubroempresa = $request -> rubro;
      $empresa->nombreempresa =  $request -> nombreEmpresa;

      $empresa->save();*/
      
     // return "Guardado con exito";
      //dd($request);
      return $BalanceGeneral;

    }
    
}
