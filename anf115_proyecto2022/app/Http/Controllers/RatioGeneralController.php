<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Empresa;//Modelo, para CURD de la empresa
use App\Models\Ratio;
use App\Models\Tiporatio;
use App\Models\Ratiogeneral;

class RatioGeneralController extends Controller
{
    //

    public function actualizarRatioGeneralGet(){
    
        $listRatios = Ratio::join('Ratiogeneral','Ratiogeneral.idgeneralratio', '=', 'Ratio.idratio')
                            ->select('Ratiogeneral.idgeneralratio','Ratiogeneral.valorratiogeneral', 'Ratio.nombreratio', 'Ratio.idtiporatio')
                            ->orderBy('idtiporatio')
                            ->get();

        $tipoRatio = Tiporatio::select('nombretiporatio', 'idtiporatio')
                              ->get();
       // dd($listRatios);
//echo $listRatios;
        return view('TablaFormRatioGeneral', compact('listRatios', 'tipoRatio'));
    }

    public function actualizarRatioGenera($idGeneralRatio){

        $ratioGeneral = Ratio::join('Ratiogeneral','Ratiogeneral.idgeneralratio', '=', 'Ratio.idratio')
                            ->select('Ratiogeneral.idgeneralratio','Ratiogeneral.valorratiogeneral', 'Ratio.nombreratio', 'Ratio.idtiporatio')
                            ->where('idgeneralratio', '=', $idGeneralRatio)
                            ->get();

        $nombreTipoRatio = Tiporatio::select('nombretiporatio')
                                    ->where('idtiporatio', '=', $ratioGeneral[0]->idtiporatio)->get();;

       $nombreTratio =$nombreTipoRatio[0]->nombretiporatio;               

                            
//echo $ratioGeneral;
        return view('ActualizarRatioGeneral', compact('idGeneralRatio', 'ratioGeneral', 'nombreTratio'));
    }

    public function actualizarRatioGeneralPost(Request $request){
      //  dd($request);
        $valorRatioGeneral = $request->valorRatioGeneral;
        $idGeneralRatio = $request->idGeneralRatio;

        $ratioGeneral = Ratiogeneral::find($idGeneralRatio);
        $ratioGeneral->valorratiogeneral = $valorRatioGeneral;

        $ratioGeneral->save();
        return redirect()->route('actualizarRatioGeneral_Get');

    }
}
