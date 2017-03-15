<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use CrudTrait;
    //

    protected $table = 'clientes';
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
        'cliente_promotor_id',
    ];

    public static $rules = [
        'nombre' => 'required',
        'rfc' => 'required|unique:clientes',
        'cliente_promotor_id' => 'required',
    ];

    public function cliente_promotor()
    {
        return $this->hasOne('App\Models\ClientePromotor', 'id', 'cliente_promotor_id');
    }
}
