<?php

namespace App\Http\Controllers;

use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Cuentageneral;
use Exception;

/**
 * Class CatalogoController
 * @package App\Http\Controllers
 */
class CatalogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catalogos = Catalogo::paginate();

        return view('catalogo.index', compact('catalogos'))
            ->with('i', (request()->input('page', 1) - 1) * $catalogos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catalogo = new Catalogo();
        $empresas = Empresa::select(['idempresa','nombreempresa'])->pluck('nombreempresa', 'idempresa')->toArray();
        $cuentas = Cuentageneral::select(['codigocuenta'])->pluck('codigocuenta')->toArray();
        return view('catalogo.create', compact('catalogo', 'empresas', 'cuentas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Catalogo::$rules);

        $catalogo = Catalogo::create($request->all());

        return redirect()->route('catalogos.index')
            ->with('success', 'Catalogo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($idEmpresa,$codigocuenta)
    {
        $catalogo = Catalogo::where('idempresa', $idEmpresa)->where('codigocuenta',$codigocuenta)->get();

        return view('catalogo.show', compact('catalogo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idEmpresa, $codigocuenta)
    {
        //$catalogo = Catalogo::find($id);
        $catalogo = Catalogo::where('idempresa', $idEmpresa)->where('codigocuenta',$codigocuenta)->first();

        return view('catalogo.edit', compact('catalogo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Catalogo $catalogo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idEmpresa, $codigocuenta)
    {
        request()->validate(Catalogo::$rules);

        $catalogo = Catalogo::where('idempresa', $idEmpresa)->where('codigocuenta',$codigocuenta);

        $catalogo->update(['NOMBRECUENTA'=>$request->NOMBRECUENTA]);

        return redirect()->route('catalogos.index')
            ->with('success', 'Catalogo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($idEmpresa, $codigocuenta)
    {
        $type="success";
        $message="Catalogo deleted successfully";
        try{
            
            $catalogo = Catalogo::where('idempresa', $idEmpresa)->where('codigocuenta',$codigocuenta)->delete();
           
        } catch(Exception $e){
            $type="warning";
            $message="Cannot delete a parent row";
        }

        return redirect()->route('catalogos.index')->with($type, $message);
    }
}
