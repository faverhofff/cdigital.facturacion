<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class ClientePromotor extends Model
{
    use CrudTrait;
    //

    protected $table = 'cliente_promotors';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = [
        'nombre',
        'rfc',
        'calle',
        'noExterior',
        'colonia',
        'municipio',
        'estado',
        'pais',
        'codigoPostal',
    ];

    public static $rules = [
        'nombre' => 'required',
        'rfc' => 'required|unique:cliente_promotors',
    ];

    public function clientes()
    {
        return $this->hasMany('App\Models\Cliente');
    }
}
