<?php

namespace App\Http\Controllers\ClientePromotor;

use App\Models\DiarioSalida;
use App\Models\Cliente;
use App\Models\ClientePromotor;
use App\Repositories\EmpresaRepository;
use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use Illuminate\Http\Request;
use App\Http\Requests\DiarioSalidaRequest as StoreRequest;
use App\Http\Requests\DiarioSalidaRequest as UpdateRequest;

class DiarioSalidaCrudController extends CrudController
{

    private $EMRep;

    function __construct( EmpresaRepository $EMPRep ) {
        parent::__construct();

        $this->EMRep = $EMPRep;

        $this->middleware('no_admin', ['except' => ['index', 'edit']]);
    }

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\DiarioSalida");
        $this->crud->setRoute("diario/salida/index");
        $this->crud->setEntityNameStrings('Diario Salida', 'Diario Salida');

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
                'name'  => 'movimiento',
                'label' => '#',
                'type'  => 'text',
            ],
            [
                'name'  => 'factura',
                'label' => 'FACT',
                'type'  => 'text',
            ],
            [
                'name'  => 'cliente_id',
                'label' => 'CLIENTE',
                'type'  => 'select',
                'entity'=> 'cliente',
                'model' => 'App\Models\Cliente',
                'attribute' => 'nombre',
            ],           
            [
                'name'  => 'empresa_id',
                'label' => 'EMPRESA',
                'type'  => 'select',
                'entity'=> 'empresaReal',
                'model' => 'App\Models\Empresa',
                'attribute' => 'nombre',
            ],
            [
                'name'  => 'deposito',
                'label' => 'DEP&Oacute;SITO',
                'type'  => 'text',
            ],            
            [
                'label' => 'SUBTOTAL',
                'name' => 'subtotal',
                'type'  => 'text',
            ],
            [
                'name'  => 'regcte',
                'label' => 'REG.CTE',
                'type'  => 'text',
            ],                        
            [
                'name'  => 'regprov',
                'label' => 'REG.PROV',
                'type'  => 'text',
            ],                        
            [
                'name'  => 'compdesp',
                'label' => 'COMP.DESP',
                'type'  => 'text',
            ],                        

        ]);

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    /**
     * { function_description }
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function create(){
        return view('promotor.diario-salida.create')->with('empresas', $this->EMRep->getEmpresas());
    }

    public function edit($id){
        return view('promotor.diario-salida.views')
            ->with('data', DiarioSalida::find($id))
            ->with('empresas', $this->EMRep->getEmpresas());
    }

	public function store(StoreRequest $request)
	{
		// your additional operations before save here
        $redirect_location = parent::storeCrud();

        // Agregar los cliente
        if ( strpos($request->get('cliente_promotor',null), '->') )
            $cliente_promotor =  ClientePromotor::find($request->get('cliente_promotor'));
        else
            $cliente_promotor =  ClientePromotor::where('nombre', $request->get('cliente_promotor',null));
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
        $this->data['entry']->save();

        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}

	public function update(UpdateRequest $request)
	{
		// your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}

    public function getClientes(Request $request) 
    {
        $term = trim($request->a);

        if (empty($term)) 
            return \Response::json([]);

        $tags = Cliente::select(['id','nombre'])->where('cliente_promotor_id',$request->get('b',null))->where('nombre','like',$request->get('a','').'%')->get();

        $formatted_tags = [];        
        foreach ($tags as $tag) 
            $formatted_tags[] = ['id' => '->'.$tag->id, 'text' => $tag->nombre];

        return \Response::json($formatted_tags);        
    }

    public function getClientesPromotores(Request $request) 
    {
        
        // return \Response::json( $data , 200);
        $term = trim($request->a);

        if (empty($term)) 
            return \Response::json([]);

        $tags = ClientePromotor::select(['id','nombre'])->where('nombre','like','%'.$request->get('a','').'%')->limit(25)->get();

        $formatted_tags = [];        
        foreach ($tags as $tag) 
            $formatted_tags[] = ['id' => '->'.$tag->id, 'text' => $tag->nombre];

        return \Response::json($formatted_tags);

    }
}
