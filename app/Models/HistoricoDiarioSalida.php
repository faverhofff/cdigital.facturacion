<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class HistoricoDiarioSalida extends Model
{
    use CrudTrait;
    //

    protected $table = 'diario_salida_historico_depositos';
    public $timestamps = false;
  
}
