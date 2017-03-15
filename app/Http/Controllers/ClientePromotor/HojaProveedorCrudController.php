<?php

namespace App\Http\Controllers\ClientePromotor;

use App\User;
use App\Models\Factura;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DiarioSalidaRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class HojaProveedorCrudController extends Controller
{

    private $FRep;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DiarioSalidaRepository $FRep)
    {
        $this->FRep = $FRep;
    }

    /**
     * { function_description }
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function index() {
        return view('promotor.hoja-proveedor.index');
    }

    /**
     * { function_description }
     *
     * @param      <type>  $mes    The mes
     * @param      <type>  $dia    The dia
     * @param      <type>  $ano    The ano
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function view($mes, $dia, $ano) {
        return view('promotor.hoja-proveedor.view')->with('solicitudes', $this->FRep->getXFecha($dia, $mes, $ano, \Auth::user()->id));
    }
    
    /**
     * Sets the interes.
     *
     * @param      <type>                    $id       The identifier
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function setInteres($id, Request $request, DiarioSalidaRepository $diario) {
        return $diario->setData( $id, $request->get('interes', 0), $request->get('recibop') );
    }
}
