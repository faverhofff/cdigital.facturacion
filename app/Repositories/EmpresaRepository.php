<?php

namespace App\Repositories;

use App\RoleUser;
use App\Models\Empresa;
use App\Models\EmpresaDataFactura;
use App\Models\Concepto;
use App\Models\ConceptoVirtual;
use App\Models\UserEmpresaPermiso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use InfyOm\Generator\Common\BaseRepository;

class EmpresaRepository extends BaseRepository
{

/**
     * { var_description }
     *
     * @var        array
     */
    private $_totales = ['subtotal' => 0, 'iva' => 0, 'total' => 0];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Empresa::class;
    }

    /**
     * Gets the conceptos.
     *
     * @param      <type>  $id     The identifier
     *
     * @return     array   The conceptos.
     */
    private function getConceptos($id)
    {
        return [];
        $_data = [];
        $_subtotal = 0;
        $_total = 0;
        $_iva = 0;
        foreach (Concepto::where('factura_id', $id)->get() as $key => $value) {
            $_subtotal += $value->importe;
            $_data[$key] = $value->toArray();
        }

        $_iva += $_subtotal * 0.16;
        $_total += $_iva + $_subtotal;
        $this->_totales['subtotal'] += $_subtotal;
        $this->_totales['iva'] += $_iva;
        $this->_totales['total'] += $_total;

        return $_data;
    }

    public function getEmpresasByUser($id)
    {
        $_empresas = [];
        foreach (UserEmpresaPermiso::where('user_id', $id)->get() as $item)
            $_empresas[] = $item->empresa;

        return $_empresas;
    }

    public function getEmpresas()
    {
        $_empresas = [];
        foreach (Empresa::orderBy('nombre')->get() as $item)
            $_empresas[] = $item;

        return $_empresas;
    }

    /**
     * Gets the totales.
     *
     * @return     <type>  The totales.
     */
    private function getTotales()
    {
        return $this->_totales;
    }

	/**
	 * Gets the empresa.
	 *
	 * @param      <type>  $id     The identifier
	 *
	 * @return     <type>  The empresa.
	 */
	public function getEmpresa( $id ) {
		$_data = [];
		$_data[ 'conceptos' ] = [];
        $user = RoleUser::where('user_id', $id)->first();
        $user->load('rol');
        $user = $user->toArray();
		foreach (Empresa::find($id)->toArray() as $key => $value) {

			// if ( $value == '' && !is_array($value) ) {
            if ( $user['rol']['id']=1 && $user['rol']['name']!='Cliente' && $value=='' ) {
				$value = '<input type="text" name="'.$key.'" value="" />';
			}

			if ( $key=='facturas')	:
				foreach ($value as $item) {
					$_data[ 'facturas' ][] = $item;
					// $_data[ 'conceptos' ] = array_merge( $_data[ 'conceptos' ], $this->getConceptos( $item['id'] ) );
				}
			endif;
			
			$_data[ $key ] = $value;

		}
        
		$_data['totales'] = $this->getTotales();

		return json_encode( $_data );
	}

	/**
	 * Sets the empresa data.
	 *
	 * @param      <type>  $request  The request
	 */
	public function setEmpresaData( $request, $data ) {

		$total = 0;
        $_data = $request->all();
		$_data['solicitud_factura_id'] = $data->id;
		$_data['empresa_id'] = $data->empresa_id;

		$data->folio = \Auth::user()->id .'-'. $data->folio;
		// $data->subtotal = $data->getSubtotal();

        if ( $request->get('facts', null) == null ) :
            foreach ($request->get('col1', []) as $key => $value) {
                $row = new ConceptoVirtual();

                $row->cantidad = $request->get('col1', '')[$key];
                $row->descripcion = $request->get('col2', '')[$key];
                $row->unidad = $request->get('col3', '')[$key];
                $row->valorUnitario = $request->get('col4', '')[$key];
                $row->importe = $request->get('col5', '')[$key];
                $row->solfactura = $data->id;

                $row->save();

                $total+=$request->get('col5', '')[$key];
            }
        endif;

        $data->subtotal = $total;
        $data->save();

		EmpresaDataFactura::create( $_data );
	}

	/**
	 * Gets the conceptos by factura.
	 *
	 * @param      <type>  $request  The request
	 *
	 * @return     <type>  The conceptos by factura.
	 */
	public function getConceptosByFactura( $value, $json = true ) {
		$this->getConceptos( $value );
		
		if ( $json )
			return json_encode([
								'conceptos' => Concepto::where('factura_id', $value )->get()->toArray(),
								'total' => $this->_totales
							   ]);
		else
			return ([
					'conceptos' => Concepto::where('factura_id', $value )->get()->toArray(),
					'total' => $this->_totales
				   ]);

	}

    public function getConceptosVirtualBySolicitud( $value, $json = true ) {
        $this->getConceptos( $value );
        
        if ( $json )
            return json_encode([
                                'conceptos' => Concepto::where('factura_id', $value )->get()->toArray(),
                                'total' => $this->_totales
                               ]);
        else
            return ([
                    'conceptos' => Concepto::where('factura_id', $value )->get()->toArray(),
                    'total' => $this->_totales
                   ]);

    }

    public function getEmpresasPorUsuarioPermiso($user_id, $permission_id) {
        $empresas = DB::table('empresas')->join('users_empresas_permisos', 'empresas.id', '=', 'users_empresas_permisos.empresa_id')
            ->select('empresas.*')
            ->where('users_empresas_permisos.user_id', '=', $user_id)
            ->where('users_empresas_permisos.permission_id', '=', $permission_id)
            ->get();
//        dd($empresas);

        return $empresas;
    }

    public function findByRfc( $rfc ) {
        return Empresa::where( 'rfc', '=', $rfc )->first();
    }

    public function getEntry($id){
        return Empresa::find($id);
    }

    public function createFromExcelEmpresas($data) {
        $i = 0;
        $numEmpInserted = 0;
        foreach ($data as $empresa) {
            if($i > 0) {

                $dataE['nombre'] = (isset($empresa[0]) ? $empresa[0] : null);
                $dataE['nombre_corto'] = (isset($empresa[1]) ? $empresa[1] : null);
                $dataE['rfc'] = (isset($empresa[2]) ? $empresa[2] : null);
                $dataE['calle'] = (isset($empresa[3]) ? $empresa[3] : null);
                $dataE['numeroInterior'] = (isset($empresa[4]) ? $empresa[4] : null);
                $dataE['numeroExterior'] = (isset($empresa[5]) ? $empresa[5] : null);
                $dataE['colonia'] = (isset($empresa[6]) ? $empresa[6] : null);
                $dataE['delegacion'] = (isset($empresa[7]) ? $empresa[7] : null);
                $dataE['municipio'] = (isset($empresa[8]) ? $empresa[8] : null);
                $dataE['ciudad'] = (isset($empresa[9]) ? $empresa[9] : null);
                $dataE['estado'] = (isset($empresa[10]) ? $empresa[10] : null);
                $dataE['codigoPostal'] = (isset($empresa[11]) ? $empresa[11] : null);
                $dataE['correo_1'] = (isset($empresa[12]) ? $empresa[12] : null);
                $dataE['correo_2'] = (isset($empresa[13]) ? $empresa[13] : null);
                $dataE['correo_3'] = (isset($empresa[14]) ? $empresa[14] : null);
                $dataE['sucursal_calle'] = (isset($empresa[15]) ? $empresa[15] : null);
                $dataE['sucursal_numero'] = (isset($empresa[16]) ? $empresa[16] : null);
                $dataE['sucursal_colonia'] = (isset($empresa[17]) ? $empresa[17] : null);
                $dataE['sucursal_ciudad'] = (isset($empresa[18]) ? $empresa[18] : null);
                $dataE['sucursal_estado'] = (isset($empresa[19]) ? $empresa[19] : null);
                $dataE['sucursal_codigoPostal'] = (isset($empresa[20]) ? $empresa[20] : null);
                $dataE['banco_1'] = (isset($empresa[21]) ? $empresa[21] : null);
                $dataE['datos_banco_1'] = (isset($empresa[22]) ? $empresa[22] : null);
                $dataE['cuenta_banco_1'] = (isset($empresa[23]) ? $empresa[23] : null);
                $dataE['banco_2'] = (isset($empresa[24]) ? $empresa[24] : null);
                $dataE['datos_banco_2'] = (isset($empresa[25]) ? $empresa[25] : null);
                $dataE['cuenta_banco_2'] = (isset($empresa[26]) ? $empresa[26] : null);
                $dataE['banco_3'] = (isset($empresa[27]) ? $empresa[27] : null);
                $dataE['datos_banco_3'] = (isset($empresa[28]) ? $empresa[28] : null);
                $dataE['cuenta_banco_3'] = (isset($empresa[29]) ? $empresa[29] : null);

                $validator = Validator::make($dataE, Empresa::$rules);
                if($validator->passes()){
                    $emp = $this->create($dataE);
                    $numEmpInserted++;
                }
            }
            $i++;
        }

        return $numEmpInserted;
    }
}
