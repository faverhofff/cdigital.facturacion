<?php

namespace App\Http\Controllers\ClientePromotor;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\ClientePromotor;
use App\Models\SeguimientoFactura;
use App\Models\Empresa;
use App\Models\Proveedor;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SeguimientoFacturaRequest as StoreRequest;
use App\Http\Requests\SeguimientoFacturaRequest as UpdateRequest;

class SeguimientoFacturaCrudController extends CrudController
{

    function __construct() {
        parent::__construct();

    }

    public function create()
    {
        return view('promotor.seguimiento-factura.create', ['empresas' => Empresa::orderBy('nombre')->get(), 'proveedor' => Proveedor::orderBy('nombre')->get() ]);
    }

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\SeguimientoFactura");
        $this->crud->setRoute("seguimiento/facturacion");
        $this->crud->setEntityNameStrings('Seguimiento de Factura', 'Seguimiento de Factura');

        // if ( \Auth::user()->role->first()->id != 2) {
        //     $this->crud->denyAccess('create');
        //     $this->crud->denyAccess('delete');
        // }

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/


        $this->crud->setFromDb();

        $this->crud->setColumns([
            [
                'name'  => 'movimiento',
                'label' => 'MOVIMIENTO',
                'type'  => 'text',
            ],
            [
                'name'  => 'fecha_pago',
                'label' => 'F.PAGO',
                'type'  => 'text',
            ], 
            [
                'name'  => 'cliente_promotor_id',
                'label' => 'CLIENTE',
                'type'  => 'select',
                'entity'=> 'cliente',
                'model' => 'App\Models\Cliente',
                'attribute' => 'nombre',
            ],            
            [
                'name'  => 'folio',
                'label' => 'FOLIO',
                'type'  => 'text',
            ], 
            [
                'name'  => 'factura',
                'label' => 'FACTURA',
                'type'  => 'text',
            ],
            [
                'name'  => 'cantidad',
                'label' => 'CANTIDAD',
                'type'  => 'text',
            ], 
        ]);

    }

    public function store(StoreRequest $request)
    {
        $redirect_location = parent::storeCrud();

        // Agregar los cliente
        if ( strpos($request->get('cliente_promotor',null), '->') )
            $cliente_promotor =  ClientePromotor::find($request->get('cliente_promotor'));
        else
            $cliente_promotor = ClientePromotor::where('nombre', $request->get('cliente_promotor',null));
        if ($cliente_promotor->count()==0) {
            $cliente_promotor = new ClientePromotor();
            $cliente_promotor->nombre=$request->get('cliente_promotor');
            $cliente_promotor->save();
        } else $cliente_promotor = $cliente_promotor->first();        

        $this->data['entry']->cliente_promotor_id = $cliente_promotor->id;
        $this->data['entry']->save();

        return $redirect_location;
    }

    public function edit( $id ){
        return view('promotor.seguimiento-factura.edit')
            ->with('data', SeguimientoFactura::find( $id ) )
            ->with('empresas', Empresa::get( ))
            ->with('proveedor', Empresa::get( ));
    }

}
