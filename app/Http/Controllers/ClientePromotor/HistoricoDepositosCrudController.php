<?php

namespace App\Http\Controllers\ClientePromotor;

use Illuminate\Http\Request;
use App\Models\SolicitudFactura;
use App\Models\DiarioSalida;
use App\Models\HistoricoDepositos;
use App\Models\Cliente;
use App\Models\ClientePromotor;
use App\Models\HistoricoDiarioSalida;
use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\HistoricoDepositosRequest as StoreRequest;
use App\Http\Requests\HistoricoDepositosRequest as UpdateRequest;

class HistoricoDepositosCrudController extends CrudController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('no_admin', ['except' => ['index', 'edit']]);
    }    

    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("App\Models\HistoricoDepositos");
        $this->crud->setRoute("historico/depositos");
        $this->crud->setEntityNameStrings('hist&oacute;rico', 'Hist&oacute;rico Dep&oacute;sitos');

        if ( \Auth::user()->role->first()->name == 'Administrador General')
            $this->crud->denyAccess('create');
        elseif( \Auth::user()->role->first()->name == 'Cliente' )
            $this->crud->addClause('where', 'user_id', '=', \Auth::user()->id);

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->setFromDb();

        $this->crud->setColumns([
            [
                'name'  => 'metodo_pago',
                'label' => 'M&Eacute;TODO DE PAGO',
                'type'  => 'text',
            ],
            [
                'name'  => 'deposito',
                'label' => 'DEPOSITO',
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
                'name'  => 'resumen',
                'label' => 'RES&Uacute;MEN',
                'type'  => 'text',
            ] 
        ]);

    }

    public function create() {
        return view('promotor.historico-pagos.create')->with('solicitudes', SolicitudFactura::get());
    }

    public function edit($id) {
        return view('promotor.historico-pagos.edit')->with('data', HistoricoDepositos::find($id));   
    }

    /**
     * { function_description }
     *
     * @param      StoreRequest  $request  The request
     *
     * @return     <type>        ( description_of_the_return_value )
     */
    public function store(StoreRequest $request)
    {
        $total = 0;
        $redirect_location = parent::storeCrud();
        $this->data['entry']->deposito = number_format($this->data['entry']->deposito, 2);
        $this->data['entry']->load('solicitud');
        $this->data['entry']->save();
        
        foreach ($request->get('movimientos',[]) as $key => $value) {
            $diario = DiarioSalida::find($value); $total+=$diario->deposito;
            HistoricoDiarioSalida::insert([ 'diario_salida_id' => $diario->id, 'historico_depositos_id' => $this->data['entry']->id ]);
        }

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

        if ( strpos($request->get('cliente',null), '->') )
            $cliente = Cliente::find($request->get('cliente'));
        else
            $cliente = Cliente::where('nombre', $request->get('cliente',null));
        if ($cliente->count()==0) {
            $cliente = new Cliente();
            $cliente->nombre=$request->get('cliente');
            $cliente->cliente_promotor_id = $cliente->id;
            $cliente->save();
        } else $cliente = $cliente->first();


        $this->data['entry']->cliente_id = $cliente->id;
        $this->data['entry']->cliente_promotor_id = $cliente_promotor->id;
        $this->data['entry']->deposito = $total;
        $this->data['entry']->save();

        return $redirect_location;
    }

    /**
     * { function_description }
     *
     * @param      UpdateRequest  $request  The request
     *
     * @return     <type>         ( description_of_the_return_value )
     */
    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud();
        return $redirect_location;
    }

    /**
     * Gets the movimientos.
     *
     * @param      Request  $request  The request
     *
     * @return     <type>   The movimientos.
     */
    public function getMovimientos(Request $request) 
    {
        $term = trim($request->q);

        if (empty($term)) 
            return \Response::json([]);

        $tags = DiarioSalida::where('movimiento', 'like', '%'.$term.'%')->limit(25)->get();

        $formatted_tags = [];        
        foreach ($tags as $tag) 
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->movimiento];

        return \Response::json($formatted_tags);
    }
}
