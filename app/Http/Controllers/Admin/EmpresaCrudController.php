<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ImporterXMLEmpresaRequest;
use App\Repositories\EmpresaRepository;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\EmpresaRequest as StoreRequest;
use App\Http\Requests\EmpresaRequest as UpdateRequest;

class EmpresaCrudController extends CrudController
{

    private $empresaRepository;

    public function __construct(EmpresaRepository $empresaRepository)
    {

        $this->empresaRepository = $empresaRepository;
        parent::__construct();
    }

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Empresa");
        $this->crud->setRoute(config('backpack.base.route_prefix') . "/empresa");
        $this->crud->setEntityNameStrings('empresa', 'empresas');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        $this->crud->setFromDb();

        $this->crud->setColumns([]);

        $this->crud->addColumn([
            'name' => 'nombre_corto', // The db column name
            'label' => "Nombre corto", // Table column heading
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'rfc', // The db column name
            'label' => "RFC", // Table column heading
            'type' => 'text'
        ]);

//        $this->crud->addColumn([ // n-n relationship (with pivot table)
//            'label' => 'Facturas',
//            'type' => 'select_multiple',
//            'name' => 'facturas',
//            'entity' => 'facturas',
//            'attribute' => 'folio',
//            'model' => "App\Models\Factura",
//            'pivot' => true,
//        ]);

        $this->crud->addField([
            'name' => 'nombre',
            'label' => "Nombre de la empresa",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'nombre_corto',
            'label' => "Nombre Corto",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'rfc',
            'label' => "RFC",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'codigoPostal',
            'label' => "Código Postal",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'sucursal_calle',
            'label' => "Calle (Sucursal)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'sucursal_numero',
            'label' => "Número (Sucursal)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'sucursal_colonia',
            'label' => "Colonia (Sucursal)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'sucursal_ciudad',
            'label' => "Ciudad (Sucursal)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'sucursal_estado',
            'label' => "Estado (Sucursal)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'sucursal_codigoPostal',
            'label' => "Código Postal (Sucursal)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'banco_1',
            'label' => "Nombre (Banco 1)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'datos_banco_1',
            'label' => "Datos (Banco 1)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'cuenta_banco_1',
            'label' => "Cuenta (Banco 1)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'banco_2',
            'label' => "Nombre (Banco 2)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'datos_banco_2',
            'label' => "Datos (Banco 2)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'cuenta_banco_2',
            'label' => "Cuenta (Banco 2)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'banco_3',
            'label' => "Nombre (Banco 3)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'datos_banco_3',
            'label' => "Datos (Banco 3)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addField([
            'name' => 'cuenta_banco_3',
            'label' => "Cuenta (Banco 3)",
            'type' => 'text',
        ], 'update/create/both');

        $this->crud->addButtonFromView('top', 'import-xml-button', 'btn-import-xml', 'after');
//        $this->crud->addButton('line', 'importar_xml_empresa_boton', 'model_function', 'importar_xml_empresa');

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

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
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

    public function importer()
    {
        return view('admin.empresas.importer');
    }

    public function process_importer(ImporterXMLEmpresaRequest $request)
    {
        $excel_file = $request->file('excel_file');

        $destinationPath = storage_path('uploads');
        $filename = $excel_file->getClientOriginalName();
        $upload_success = $excel_file->move($destinationPath, $filename);
        \Excel::load($destinationPath.'\\'.$filename, function($reader) {
            $reader->sheet('Hoja1', function($sheet) {
                $numEmpInserted = $this->empresaRepository->createFromExcelEmpresas( $sheet->toArray() );
                \Alert::success('XML importado correctamente. '.$numEmpInserted.' empresas insertadas.')->flash();
            });
        });

        return redirect('empresa');
    }
}
