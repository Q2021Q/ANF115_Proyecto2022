<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CuentaGeneralController;

use App\Http\Controllers\CatalogoController;

use App\Http\Controllers\CatalogoImportController;
use App\Http\Controllers\RatioController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//nombreURL es cualquier nombre, con este se accede desde el navegador
//el nombre (nombreURL) NO ESTA relacionado con ningun archivo del proyecto

//          nombreURL              controlador ----------->//nobre de lafuncion dentro del controlador
route::get('Empresa_View/{a}/{b}',[EmpresaController::class,'viewEmpresa']);

//route::get('Empresa_View',[EmpresaController::class,'mensaje']);

route::get('mensaje',[EmpresaController::class,'mensaje']);

route::get('pagoLaboral/{dias}/{salD}',[EmpresaController::class,'pagoLaboral']);

route::get('salir',[EmpresaController::class,'salir'])->name('salir_salir');//Es la forma de la ruta para redireccionar

                    //fucion                //En la vista GuardarEmpresaView, entrada en el navegador                                           
                                                             
route::get('formEmpresa',[EmpresaController::class,'formInsertarEmpresa'])->name('empresa_insert');


route::get('ImporformBalanceGeneral/{idEmpresa}',[CuentaGeneralController::class,'importarBalanceGeneral'])->name('importar_balance_get');

route::get('ImporformEstadoResul/{idEmpresa}',[CuentaGeneralController::class,'importarEstadoResultado'])->name('importar_estado_resultados');

route::get('ImporformCatalogo/{idEmpresa}',[CatalogoImportController::class,'importarCatalogo'])->name('importar_catalogo');

route::get('/',[EmpresaController::class,'empresaHomeView'])->name('home_empresa');


route::get('gestionarEmpresaRedirec/{idEmpresa}',[EmpresaController::class,'apartadoEmpresaRedirec'])->name('EmpresaGestion_redirec');
route::get('formEmpresa',[EmpresaController::class,'formInsertarEmpresa'])->name('empresa_insert');
route::get('gestionarEmpresa/{idEmpresa}',[EmpresaController::class,'apartadoEmpresa'])->name('EmpresaGestion');


route::get('comparacionRatioGeneral/{idEmpresa}',[RatioController::class,'comparacionRatioGeneraRedirec'])->name('comparacionRatio_General');

//------------------------------------------
route::get('comparacionRatio_periodoAB/{idEmpresa}',[RatioController::class,'comparacionRatioPeriodoA_periodoB_Redirec'])->name('comparacionRatio_periodoAperidoB');

route::get('importarBalanceRedi/{cuentasBalance1}',[CuentaGeneralController::class,'importarBalanceRedirec'])->name('importarBalance_Redirec');

                                                   //fucion                //En la vista GuardarEmpresaView                                          
route::post('guardarEmp',[EmpresaController::class,'guardarEmpresa'])->name('guardar_empresa_e');

route::post('importarBalaneceG',[CuentaGeneralController::class,'importarBalance'])->name('importar_balance');

route::post('importarCatalogoCsv',[CatalogoImportController::class,'importarCatalogoCSV'])->name('importarCatalogo_CSV');

route::post('comparacionRatioGeneralPost',[RatioController::class,'comparacionRatioGeneral'])->name('comparacionRatio_General_post');

//---------------------------------------------------------------------------
//-------------------------------------------
//------------------------
route::post('comparacionRatioPeriodoABpost',[RatioController::class,'comparacionRatioPeriodoAB'])->name('comparacionRatio_periodoAB');
//-----------------------------------------------------------
// Route::get('/', function () {
//     return view('index');
// });
// /*----------------------------------------------------------------------------------------------------------------------------------------------------*/

Route::get('/empresa', function () {
    return view('GuardarEmpresaView');
});

Route::get('/importar', function () {
    return view('ImportarBalanceGeneralView');
});

Route::get('/catalogos/{idEmpresa}/{codigocuenta}', [CatalogoController::class, 'show'])->name('catalogos.show');;
Route::resource('/catalogos', CatalogoController::class)->except([
    'show'
]);
Route::PATCH('/catalogos/{idEmpresa}/{codigocuenta}', [CatalogoController::class, 'update'])->name('catalogos.update');
Route::GET('/catalogos/{idEmpresa}/{codigocuenta}/edit', [CatalogoController::class, 'edit'])->name('catalogos.edit');
Route::DELETE('/catalogos/{idEmpresa}/{codigocuenta}', [CatalogoController::class, 'destroy'])->name('catalogos.destroy');
