<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Empresa;//Modelo, para CURD de la empresa
use App\Models\Rubroempresa; 
use App\Models\EmpresaHome;
use App\Models\GestionEmpresaView;

use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Support\Facades\Storage;


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
        // $rubroEmpresa = array();
        $rubroEmpresa =  Rubroempresa::all();
    return view('GuardarEmpresaView', compact('rubroEmpresa'));
    }

    public function guardarEmpresa(Request $request){

        // $this->validate($request,[
        //     'empresa' => 'required',
        //     'nombreEmpresa' => 'required',
        //     'rubro' => 'required|numeric',
        //   ]);

    
    try {
        
        $imagenEmpresa = $request->file('imagen')->store('public/imagenes');
        //dd($request);
        $url = Storage::url($imagenEmpresa);

        $empresa = new Empresa;
        $empresa->idempresa = $request -> idEmpresa;
        $empresa->idrubroempresa = $request -> rubroEmpresa;
        $empresa->nombreempresa =  $request -> nomEmpresa;
        $empresa->nombrefotoempresa =  $url;
        $insert = $empresa->save();

        // Swal.fire(
        //     'Good job!',
        //     'You clicked the button!',
        //     'success'
        // );

        //$rubroEmpresa =  Rubroempresa::all();
       
        $listEmpresa = Empresa::all();

       // return view('EmpresaHome', compact('listEmpresa'));

       // return redirect('home_empresa')->with('listEmpresa', $listEmpresa);
       return redirect(route('home_empresa'));

    } catch (\Exception $e) {
       
        $listEmpresa = Empresa::all();
      //  return view('EmpresaHome', compact('listEmpresa'));
    }
   // return redirect(route('home_empresa'));

    }

    public function opcionFuncionEmpresa(Request $request){
        dd($request);
    }

    public function empresaHomeView(){
        $listEmpresa = Empresa::all();
        
        //return redirect('home_empresa');
        return view('EmpresaHome', compact('listEmpresa'));
    }

    public function apartadoEmpresa($idEmpresa){
        $nombreEmpresa = Empresa::select(['nombreempresa'])->where('idempresa', '=', $idEmpresa)->get();
        $nomEmpresa = $nombreEmpresa[0]->nombreempresa;
        return view('GestionEmpresaView', compact('idEmpresa', 'nomEmpresa'));
    }

    public function apartadoEmpresaRedirec($idEmpresa){
     // return 
    }

    public function pagoLaboral($disaT, $salarioDia){

        $salario = $disaT*$salarioDia;

        dd($salario);
        return "El pago es $salario mensual";
    }

    

}
