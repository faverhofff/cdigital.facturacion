<?php

namespace App\Repositories;

use App\Models\Empresa;
use App\Models\SolicitudFactura;
use App\Models\DiarioSalida;
use App\Models\ConceptoVirtual;
use Illuminate\Support\Facades\DB;
use InfyOm\Generator\Common\BaseRepository;

class SolicitudFacturaRepository extends BaseRepository {
	/**
	 * @var array
	 */

	/**
	 * Configure the Model
	 **/
	public function model() {
		return SolicitudFactura::class;
	}

	/**
	 * Gets the x fecha.
	 *
	 * @param      <type>  $d      { parameter_description }
	 * @param      <type>  $m      { parameter_description }
	 * @param      <type>  $y      { parameter_description }
	 *
	 * @return     <type>  The x fecha.
	 */
	public function getXFecha($d, $m, $y, $user_id) {
		if ($user_id!=\Auth::user()->id)
			return null;
		
		return DiarioSalida::whereRaw(DB::raw("DATE(created_at) = '".date("$y-$m-$d")."'"))->where('user_id', $user_id);
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $user_id  The user identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function get($user_id) {
		if ($user_id!=\Auth::user()->id)
			return null;
		
		return SolicitudFactura::where('user_id', $user_id);
	}

	/**
	 * Sets the deposito.
	 *
	 * @param      <type>  $id     The identifier
	 * @param      <type>  $value  The value
	 */
	public function setDeposito( $id, $value ) {
		$row = SolicitudFactura::find($id);
		$row->deposito = $value;
		$row->save();

		return response()->json([
		    'id' => $id
		]);
	}

	public function setTotal( $id, $value ) {
		$row = SolicitudFactura::find($id);
		$row->total = $value;
		$row->save();

		return response()->json([
		    'id' => $id
		]);
	}

	/**
	 * Sets the interes.
	 *
	 * @param      <type>  $id     The identifier
	 * @param      <type>  $value  The value
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function setInteres( $id, $value1, $value2 ) {
		$row = SolicitudFactura::find($id);
		$row->interes = $value1;
		$row->recibo = $value2;
		$row->save();

		return response()->json([
		    'id' => $id
		]);
	}	

	public function setDate( $id, $value ) {
		$row = SolicitudFactura::find($id);
		$row->fecha_depo = $value;
		$row->save();

		return response()->json([
		    'id' => $id
		]);
	}	

	/**
	 * Sets the percent.
	 *
	 * @param      <type>  $id      The identifier
	 * @param      <type>  $value1  The value 1
	 * @param      <type>  $value2  The value 2
	 */
	public function setPercent( $id, $value1, $value2 ) {
		if (!is_numeric($id))
			return;
		
		$row = SolicitudFactura::find($id);
		$row->percent = $value1.','.$value2;
		$row->save();

		return response()->json([
		    'id' => $id
		]);
	}

	/**
	 * Sets the movimiento.
	 *
	 * @param      <type>  $id      The identifier
	 * @param      string  $value1  The value 1
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function setMovimiento( $id, $value1 ) {
		if (!is_numeric($id))
			return;
		
		$row = SolicitudFactura::find($id);
		$row->movimiento = $value1;
		$row->save();

		return response()->json([
		    'id' => $id
		]);
	}

	public function createFromExcel( $data ) {
		$empresa = Empresa::where('nombre', $data[6][2]);
		if ($empresa->count() == 0) {
			$empresa = Empresa::create([
					'nombre' => $data[6][2],
					'razon' => $data[9][2],
					'rfc' => $data[10][2],
					'calle' => $data[11][2],
					'noExterior' => $data[12][2],
					'noInterior' => $data[13][2],
					'colonia' => $data[14][2],
					'estado' => $data[15][2],
					'ciudad' => $data[16][2],
					'municipio' => $data[17][2],
					'delegacion' => $data[18][2],
					'codigoPostal' => $data[19][2],
					'correo_1' => $data[20][2],
					'correo_2' => $data[21][2],
					'correo_3' => $data[22][2]
				]);
		}		
		$fp = 0;
		switch ($data[49][2]) {
			case 'PAGO EN UNA SOLA EXHIBICION':
				$fp = 1;
				break;
			case 'PAGO DE PARCIALIDAD (Ejemplo 1/3 - 2/3 - 3/3)':
				$fp = 2;
				break;
			case 'PAGO EN PARCIAIDADES':
				$fp = 3;
				break;
		}

		$mp = 0;
		switch ($data[50][2]) {
			case 'NO IDENTIFICADO':
				$mp = 1;
				break;
			case 'EFECTIVO':
				$mp = 2;
				break;
			case 'CHEQUE':
				$mp = 3;
				break;
			case 'TRANSFERENCIA ELECTRONICA':
				$mp = 4;
				break;
			case 'TARJETA':
				$mp = 5;
				break;				
		}

		if ( SolicitudFactura::where('folio',$data[1][1])->count() > 0 ) {
			$s = SolicitudFactura::where('folio',$data[1][1])->first();
			ConceptoVirtual::where('solfactura', $s->id)->delete();

			$s->user_id = \Auth::user()->id;
			$s->empresa_id = $empresa->first()->id;
			$s->folio = $data[1][1];
			$s->resumen = $data[46][1];
			$s->forma_pago = $fp;
			$s->metodo_pago = $mp;
			$s->digito = $data[51][2];
			$s->subtotal = str_replace("$", "", $data[41][5]);

			$s->save();
		} else {
			$s = SolicitudFactura::create([
				'user_id' => \Auth::user()->id,
				'empresa_id' => $empresa->first()->id,
				'folio' => $data[1][1],
				'resumen' => $data[46][1],
				'forma_pago' => $fp,
				'metodo_pago' => $mp,
				'digito' => $data[51][2],
				'subtotal' => str_replace("$", "", $data[41][5]),
			]);
		}

		$total = 0;
		for($i=0; $i<=14;$i++) {
			if ($data[25+$i][1]!='') {
				$total+= trim(str_replace('$', '', $data[25+$i][5]));
				ConceptoVirtual::create([
					'cantidad' => $data[25+$i][1],
					'descripcion' => $data[25+$i][2],
					'unidad' => $data[25+$i][3],
					'valorUnitario' => $data[25+$i][4],
					'importe' => trim(str_replace('$', '', $data[25+$i][5])),
					'solfactura' => $s->id,
				]);		
			}
		}

	}

}
