<?php

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
Route::middleware('authenticated', \App\Http\Middleware\Authenticated::class);
Route::middleware('cajero', \App\Http\Middleware\Cajero::class);

Route::get('/', function () {
    return view('home');
})->middleware('authenticated');

//Routes for Admin
Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['admin'],
    'namespace' => 'Admin'
], function() {

    CRUD::resource('cliente', 'ClienteCrudController');
    CRUD::resource('empresa', 'EmpresaCrudController');
    CRUD::resource('user', 'UserCrudController');
    CRUD::resource('clientepromotor', 'ClientePromotorCrudController');
    Route::get('emp/importer', ['as' => 'importer_empresa', 'uses' => 'EmpresaCrudController@importer']);
    Route::post('importer', ['as' => 'process_importer_empresa', 'uses' => 'EmpresaCrudController@process_importer']);
});

//Routes for Clients Promotor
Route::group([
    'prefix' => '/',
    'middleware' => ['auth'],
    'namespace' => 'ClientePromotor'
], function() {

    CRUD::resource('seguimiento/facturacion', 'SeguimientoFacturaCrudController');
    CRUD::resource('solicitud/factura', 'SolicitudfacturaCrudController');
    CRUD::resource('historico/depositos', 'HistoricoDepositosCrudController');
    CRUD::resource('hoja/proveedor', 'HojaProveedorCrudController');
    CRUD::resource('diario/salida/index', 'DiarioSalidaCrudController');

    Route::get('dame/clientes/por', ['uses' => 'DiarioSalidaCrudController@getClientes']);
    Route::get('dame/clientes/promotores', ['uses' => 'DiarioSalidaCrudController@getClientesPromotores']);

    Route::get('dame/movimientos', ['uses' => 'HistoricoDepositosCrudController@getMovimientos']);
    Route::post('solicitud/factura/import', ['uses' => 'SolicitudfacturaCrudController@importExcel']);
    Route::get('/get/empresa/{id_empresa}', ['uses' => 'SolicitudfacturaCrudController@getEmpresas']);
    Route::post('/get/empresa/factura/conceptos/{id_empresa}/{id_factura}', ['uses' => 'SolicitudfacturaCrudController@getConceptosByFactura']);
    // Route::get('/diario/salida', ['uses' => 'DiarioSalidaController@view']);
    Route::get('/diario/salida/{mes}/{dia}/{ano}', ['uses' => 'DiarioSalidaController@view']);
    Route::post('/diario/salida/set/deposito/{id_solicitud}', ['uses' => 'DiarioSalidaController@setDeposito']);
    Route::post('/diario/salida/set/movimiento/{id_solicitud}', ['uses' => 'DiarioSalidaController@setMovimiento']);
    Route::post('/diario/salida/set/percent/{id_solicitud}', ['uses' => 'DiarioSalidaController@setPercent']);
    Route::get('/hoja/proveedor/{mes}/{dia}/{ano}', ['uses' => 'HojaProveedorCrudController@view']);
    Route::post('/hoja/proveedor/set/total/{id_solicitud}', ['uses' => 'HojaProveedorCrudController@setTotal']);
    Route::post('/hoja/proveedor/set/{id_solicitud}', ['uses' => 'HojaProveedorCrudController@setInteres']);
    Route::post('/hoja/proveedor/set/date/{id_solicitud}', ['uses' => 'HojaProveedorCrudController@setDate']);

    // Route::get('/diario/salida/historico/pago', ['uses' => 'HistoricoDepositosCrudController@index']);
});

//Routes for Cajero
Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['cajero'],
    'namespace' => 'Cajero'
], function() {
    CRUD::resource('cajasalida', 'CajaSalidaCrudController');
    CRUD::resource('cajaentrada', 'CajaEntradaCrudController');
    Route::get('caja/info', ['as' => 'caja-info', 'uses' => 'CajaSalidaCrudController@infoCaja']);
});