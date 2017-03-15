<?php

namespace App\Http\Controllers\ClientePromotor;

use Session;
use Redirect;
use Validator;
use App\RoleUser;
use App\Models\Empresa;
use App\Models\ConceptoVirtual;
use Illuminate\Http\Request;
use App\Models\SolicitudFactura;
use Illuminate\Support\Facades\Input;
use App\Repositories\EmpresaRepository;
use App\Repositories\SolicitudFacturaRepository;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SolicitudfacturaRequest as StoreRequest;
use App\Http\Requests\SolicitudfacturaRequest as UpdateRequest;

class SolicitudfacturaCrudController extends CrudController
{

    private $EMRep;

    private $SFRep;

    function __construct( EmpresaRepository $EMPRep, SolicitudFacturaRepository $SFRep ) {
        parent::__construct();

        $this->middleware('no_admin', ['except' => ['index', 'edit']]);
        
        $this->EMRep = $EMPRep;

        $this->SFRep = $SFRep;
    }

    /**
     * { function_description }
     */
    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\SolicitudFactura");
        $this->crud->setRoute("solicitud/factura");
        $this->crud->setEntityNameStrings('solicitudfactura', 'solicitudfacturas');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->setFromDb();

        $this->crud->setColumns([
            [
                'name'  => 'id',
                'label' => ucfirst('#'),
                'type'  => 'text',
            ],
            [
                'name'  => 'folio',
                'label' => 'FOLIO',
                'type'  => 'text',
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
                'label' => 'SUBTOTAL',
                'name' => 'subtotal',
                'type'  => 'text',
            ]            

        ]);

        if ( \Auth::user()->role->first()->name == 'Administrador General')
            $this->crud->denyAccess('create');
        elseif( \Auth::user()->role->first()->name == 'Cliente' )
            $this->crud->addClause('where', 'user_id', '=', \Auth::user()->id);

        $this->crud->setEntityNameStrings('Solicitud Factura', 'Solicitud Factura');
    }


    /**
     * { function_description }
     *
     * @param      <type>  $id     The identifier
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function edit( $id ){
        return view('promotor.solicitud-factura.edit')
            ->with('data', ($factura = SolicitudFactura::find( $id ) ) )
            ->with('resumen', ConceptoVirtual::where('solfactura', $id )->get() );
    }

    /**
     * { function_description }
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function create(){
        if (\Auth::user()->role->first()->name == "Administrador General")
            redirect('/');

        return view('promotor.solicitud-factura.create')->with('empresas', $this->EMRep->getEmpresas());
    }

    /**
     * Gets the empresas.
     *
     * @param      <type>  $id     The identifier
     *
     * @return     <type>  The empresas.
     */
    public function getEmpresas( $id ) {
        return $this->EMRep->getEmpresa( $id );
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
        if ( $request->get('facts',null) != null ) :
            $validator = Validator::make($request->all(), [
                'factura' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect('solicitud/factura/create')
                            ->withErrors($validator)
                            ->withInput();
            }
        endif;

        $redirect_location = parent::storeCrud();

        $this->EMRep->setEmpresaData( $request, $this->data['entry'] );

        return $redirect_location;
	}

    /**
     * Gets the conceptos by factura.
     *
     * @param      <type>  $empresa  The empresa
     * @param      <type>  $factura  The factura
     */
    public function getConceptosByFactura( Request $request ) {
        return $this->EMRep->getConceptosByFactura( $request->input('v2') );
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
     * { function_description }
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function importExcel() {
        $files = \Illuminate\Support\Facades\Input::file('excel');

        $file_count = count($files);

        $uploadcount = 0;
        foreach($files as $file) {
          // $rules = array('file' => 'required|mimes:xls,x-excel,x-xls,vnd.openxmlformats-officedocument.spreadsheetml.sheet,msexcel'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
          $rules = array('file' => 'required'); 
          $validator = Validator::make(array('file'=> $file), $rules);
          if($validator->passes()){
            $destinationPath = storage_path('uploads');
            $filename = $file->getClientOriginalName();
            $upload_success = $file->move($destinationPath, $filename);
            $uploadcount ++;
            \Excel::load($destinationPath.'\\'.$filename, function($reader) {
                $reader->sheet('SOLICITUD FACTURA', function($sheet) {
                    $this->SFRep->createFromExcel( $sheet->toArray() );
                });

            });
          }
        }
        if($uploadcount == $file_count){
          Session::flash('success', 'Upload successfully'); 
          return Redirect::to('/solicitud/factura');
        } 
        else {
          return Redirect::to('/solicitud/factura')->withInput()->withErrors($validator);
        }
      }
}
