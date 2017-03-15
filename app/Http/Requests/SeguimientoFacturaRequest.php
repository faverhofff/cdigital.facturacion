<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SeguimientoFacturaRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'name' => 'required|min:5|max:255'
            'empresa_id' => 'required',
            'movimiento' => '',
            'fecha_pago' => '',
            'folio' => 'required',
            'factura' => 'required',
            'proveedor_id' => '',
            'cantidad' => 'required',
            'cliente_promotor_id' => '',
            'rfc' => '',
            'domicilio' => '',
            'concepto' => ''
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'empresa_id.required' => 'Debe seleccionar una empresa.',
            'folio.required' => 'El folio es obligatorio.',
            'factura.required' => 'La factura es obligatoria.',
            'cantidad.required' => 'La cantidad es obligatoria.'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
