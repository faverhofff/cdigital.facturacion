<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DiarioSalidaRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
            'movimiento' => 'required|numeric',
            'factura' => 'required',
            'cliente' => 'required',
            'cliente_promotor' => 'required',
            'empresa_id' => 'required|numeric|min:1',
            'deposito' => 'required',
            'subtotal' => 'required',
            'regcte' => 'required',
            'regprov' => 'required',
            'sofom' => '',
            'user_id' => '',
            'movimiento' => 'required|unique:diario_salida|min:3'
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
            //
        ];
    }
}
