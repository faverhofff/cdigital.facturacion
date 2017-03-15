<?php

namespace App\Repositories;

use App\User;
use App\Models\Concepto;
use App\Models\DiarioSalida;
use Illuminate\Support\Facades\DB;
use InfyOm\Generator\Common\BaseRepository;

class DiarioSalidaRepository extends BaseRepository {

	/**
	 * Configure the Model
	 **/
	public function model() {
		return DiarioSalida::class;
	}

	/**
	 * Gets the x fecha.
	 *
	 * @param      <type>  $d        { parameter_description }
	 * @param      <type>  $m        { parameter_description }
	 * @param      <type>  $y        { parameter_description }
	 * @param      <type>  $user_id  The user identifier
	 *
	 * @return     <type>  The x fecha.
	 */
	public function getXFecha($d, $m, $y, $user_id) {
		if ( \Auth::user()->role->first()->name == "Cliente" )
			return DiarioSalida::whereRaw(DB::raw("DATE(created_at) = '".date("$y-$m-$d")."'"))->where('user_id', $user_id);
		else
			return DiarioSalida::whereRaw(DB::raw("DATE(created_at) = '".date("$y-$m-$d")."'"));
	}	

	/**
	 * Sets the data.
	 *
	 * @param      <type>  $id              The identifier
	 * @param      <type>  $interes         The interes
	 * @param      <type>  $recibo_percent  The recibo percent
	 */
	public function setData( $id, $interes, $recibo_percent ) {
		$obj = DiarioSalida::find( $id );
		$obj->interes = $interes;
		$obj->recibop = $recibo_percent;
		$obj->save();

		return \Response::json('success', 200);
	}
}