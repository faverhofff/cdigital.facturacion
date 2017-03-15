<?php

namespace App\Http\Controllers\Cajero;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\CajaEntradaRequest as StoreRequest;
use App\Http\Requests\CajaEntradaRequest as UpdateRequest;

class CajaEntradaCrudController extends CrudController
{

    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("App\Models\CajaEntrada");
        $this->crud->setRoute("cajaentrada");
        $this->crud->setEntityNameStrings('Caja Entrada', 'Caja Entrada');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->setFromDb();

    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
