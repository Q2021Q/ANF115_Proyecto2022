<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Empresa;//Modelo, para CURD de la empresa

class EmpresaController extends Controller
{

    public function viewEmpresa($x, $y){
    return view('EmpresaView', compact('x', 'y'));// EmpresaView es la vista en la carpeta views
                                                      //compact() es para pasar parametros a la vista
    //segunda forma de pasar parametros a la view
    //return view('EmpresaView', ['a'=>$x, 'b'=>$y]);

    //tercera forma de pasar parametros a la view
   /* return view('EmpresaView')
    ->with('m',$x)
    ->with('n',$y);*/

    }
   
    public function mensaje(){
        $consulta = Empresa::all();
        return $consulta;
    }

    public function salir(){
        return "SALIR";
    }

    public function  formInsertarEmpresa(){
        return view('GuardarEmpresaView');
    }

    public function guardarEmpresa(Request $request){

        $this->validate($request,[
            'empresa' => 'required',
            'nombreEmpresa' => 'required',
            'rubro' => 'required|numeric',
          ]);

        $empresa = new Empresa;

      /*$empresa->idempresa = $request -> empresa;
      $empresa->idrubroempresa = $request -> rubro;
      $empresa->nombreempresa =  $request -> nombreEmpresa;

      $empresa->save();*/
      
      //return "Guardado con exito";
      dd($request);
      //return $request;

    }

    public function pagoLaboral($disaT, $salarioDia){

        $salario = $disaT*$salarioDia;

        dd($salario);
        return "El pago es $salario mensual";
    }
}
