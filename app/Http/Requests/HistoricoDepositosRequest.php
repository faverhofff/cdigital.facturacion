<?php

namespace App\Http\Requests;


use Backpack\CRUD\app\Http\Requests\CrudRequest;

class HistoricoDepositosRequest extends CrudRequest
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
            'movimientos' => 'required|array',
            'cliente' => 'required',
            'user_id' => 'required',
            'cliente_promotor' => 'required',
            'cliente' => ''
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
            'deposito.required' => 'La cantidad del de&oacute;sito es obligatorio.',
            'deposito.numeric' => 'La cantidad del de&oacute;sito es obligatorio.',
            'deposito.min' => 'La cantidad del de&oacute;sito es obligatorio.',
            'cliente_promotor.required' => 'El cliente promotor es obligatorio',
            'movimientos.required' => 'Debe tener al menos un registro del Movimiento.'
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
