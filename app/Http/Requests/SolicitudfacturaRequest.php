<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SolicitudfacturaRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
            'folio' => 'required|min:3|unique:solicitudes_factura',
            'empresa_id' => 'required|numeric|min:1',
            'forma_pago' => 'required',
            'metodo_pago' => 'required',
            'user_id' => 'required',
            'factura' => '',
            'digito' => '',
            'facts' => ''
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
            //
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
            'folio.required' => 'El valor del folio es obligatorio.',
            'folio.min' => 'El valor del folio debe tener 3 caracteres como m&iacute;nimo.',
            'folio.unique' => 'El n&uacute;mero de folio ya esta en uso en otro registro.',
            'empresa_id.required' => 'Debe seleccionar una empresa.',
            'empresa_id.min' => 'Debe seleccionar una empresa.',
            'empresa_id.numeric' => 'Debe seleccionar una empresa.',
            'factura.required' => 'Es obligatorio seleccionar una factura para la solicitud.'
        ];
    }
}
