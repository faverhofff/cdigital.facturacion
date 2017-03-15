<?php

namespace App\Http\Controllers\Cajero;

use App\Repositories\CajaEntradaRepository;
use App\Repositories\CajaSalidaRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SolicitudFactura;
use App\Models\DiarioSalida;
use App\Models\HistoricoDiarioSalida;
use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\CajaSalidaRequest as StoreRequest;
use App\Http\Requests\CajaSalidaRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CajaSalidaCrudController extends CrudController
{
    private $cajaSalidaRepository;
    private $cajaEntradaRepository;

    public function __construct(CajaSalidaRepository $cajaSalidaRepository, CajaEntradaRepository $cajaEntradaRepository)
    {
        $this->cajaSalidaRepository = $cajaSalidaRepository;
        $this->cajaEntradaRepository = $cajaEntradaRepository;
        parent::__construct();
    }

    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("App\Models\CajaSalida");
        $this->crud->setRoute("cajasalida");
        $this->crud->setEntityNameStrings('Caja Salida', 'Caja Salida');

        $this->crud->denyAccess(['create', 'delete']);

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->setFromDb();

    }

    public function index()
    {
        $this->crud->hasAccessOrFail('list');

        $this->data['crud'] = $this->crud;
        $this->data['title'] = ucfirst($this->crud->entity_name_plural);

        // get all entries if AJAX is not enabled
        if (!$this->data['crud']->ajaxTable()) {
            $this->data['entries'] = $this->data['crud']->getEntries();
        }

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('cajero.caja-salida.list', $this->data);
    }

    public function edit($id)
    {
        $this->crud->hasAccessOrFail('update');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = trans('backpack::crud.edit') . ' ' . $this->crud->entity_name;

        $this->data['id'] = $id;

        return view('cajero.caja-salida.edit', $this->data);
    }

    /**
     * { function_description }
     *
     * @param      StoreRequest $request The request
     *
     * @return     <type>        ( description_of_the_return_value )
     */
    public function store(StoreRequest $request)
    {
        $redirect_location = parent::storeCrud();
        $this->data['entry']->deposito = number_format($this->data['entry']->deposito, 2);
        $this->data['entry']->load('solicitud');
        $this->data['entry']->save();

        foreach ($request->get('movimientos', []) as $key => $value)
            HistoricoDiarioSalida::create([SolicitudFactura::where('movimiento', $value)->first()->movimiento, $this->data['entry']->id]);


        return $redirect_location;
    }

    /**
     * { function_description }
     *
     * @param      UpdateRequest $request The request
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
     * @param      Request $request The request
     *
     * @return     <type>   The movimientos.
     */
    public function getMovimientos(Request $request)
    {
        $term = trim($request->q);

        if (empty($term))
            return \Response::json([]);

        $tags = DiarioSalida::where('movimiento', 'like', '%' . $term . '%')->limit(25)->get();

        $formatted_tags = [];
        foreach ($tags as $tag)
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->movimiento];

        return \Response::json($formatted_tags);
    }

    public function infoCaja()
    {
        $data = Input::all();

        $initdate = '';
        $now = Carbon::now();
        $enddate = Carbon::now();

        $this->crud->addFilter([
            'name' => 'fecha_filter',
            'type' => 'dropdown',
            'label' => 'Fecha'
        ], [
            1 => 'Hoy',
            2 => 'Última semana',
            3 => 'Último mes',
            4 => 'Último año',
            5 => 'Personalizado',
        ],
            function ($value) {
            });
        if (isset($data['fecha_filter'])) {
            $fecha_filter = $data['fecha_filter'];

            switch ($fecha_filter) {
                case 1:
                    $initdate = Carbon::today();
                    break;
                case 2:
                    $initdate = $now->subWeeks(1);
                    break;
                case 3:
                    $initdate = $now->subMonths(1);
                    break;
                case 4:
                    $initdate = $now->subYears(1);
                    break;
                case 5:
                    $custom_initdate = Carbon::now();
                    $custom_enddate = Carbon::now();
                    if (isset($data['date_range'])) {
                        $date_range = explode('x', $data['date_range']);
                        $initdate = Carbon::parse(substr($date_range[0], 0, 10));
                        $enddate = Carbon::parse(substr($date_range[1], 0, 10));

                        $custom_initdate = $initdate;
                        $custom_enddate = $enddate;
                    }

                    $this->crud->addFilter([ // add a "simple" filter called Draft
                        'type' => 'date_range',
                        'name' => 'date_range',
                        'label' => '',
                        'custom_initdate' => $custom_initdate->format('Y-m-d'),
                        'custom_enddate' => $custom_enddate->format('Y-m-d'),
//                            $filter->options['now']
                    ],
                        false,
                        function () {
                        });

                    break;

            }
        } else {
            // Por defecto la fecha de hoy
            $initdate = Carbon::today();
        }

        $this->data['crud'] = $this->crud;
        $this->data['entries_cs'] = $this->cajaSalidaRepository->getEntriesByRange($initdate, $enddate);
        $this->data['entries_ce'] = $this->cajaEntradaRepository->getEntriesByRange($initdate, $enddate);
//        $this->data['entries_cs'] = $this->data['crud']->getEntries();
//        $this->data['entries_ce'] = $this->data['crud']->getEntries();

        return view('cajero.caja-salida.info', $this->data);


    }
}
