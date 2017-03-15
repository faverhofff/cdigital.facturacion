<?php

namespace App\Http\Controllers\ClientePromotor;

use App\User;
use App\Models\Factura;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SolicitudFacturaRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class DiarioSalidaController extends Controller
{

	private $FRep;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SolicitudFacturaRepository $FRep)
    {
    	$this->FRep = $FRep;
    }

    /**
     * { function_description }
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function index() {
    	return view('promotor.diario-salida.index');
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
    public function view() {
    	return view('promotor.diario-salida.view')->with('solicitudes', $this->FRep->get(\Auth::user()->id));
    }

    /**
     * Sets the deposito.
     *
     * @param      <type>                                        $id       The identifier
     * @param      Request                                       $request  The request
     * @param      \App\Repositories\SolicitudFacturaRepository  $FRep     The f rep
     */
    public function setDeposito( $id, Request $request, SolicitudFacturaRepository $FRep ) {
        return $FRep->setDeposito( $id, $request->input('value') );
    }

    /**
     * Sets the percent.
     *
     * @param      <type>                                        $id       The identifier
     * @param      \Illuminate\Http\Request                      $request  The request
     * @param      \App\Repositories\SolicitudFacturaRepository  $FRep     The f rep
     *
     * @return     <type>                                        ( description_of_the_return_value )
     */
    public function setPercent( $id, Request $request, SolicitudFacturaRepository $FRep ) {
        return $FRep->setPercent( $id, $request->input('v1'), $request->input('v2') );   
    }

    /**
     * Sets the movimiento.
     *
     * @param      <type>                                        $id       The identifier
     * @param      \Illuminate\Http\Request                      $request  The request
     * @param      \App\Repositories\SolicitudFacturaRepository  $FRep     The f rep
     *
     * @return     <type>                                        ( description_of_the_return_value )
     */
    public function setMovimiento( $id, Request $request, SolicitudFacturaRepository $FRep ) {
        return $FRep->setMovimiento( $id, $request->input('value') );   
    }    
}
