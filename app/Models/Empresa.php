<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Empresa extends Model
{
    use CrudTrait;

    /*
   |--------------------------------------------------------------------------
   | GLOBAL VARIABLES
   |--------------------------------------------------------------------------
   */

    protected $table = 'empresas';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['nombre', 'nombre_corto', 'rfc', 'calle', 'noInterior', 'noExterior', 'colonia', 'delegacion', 'municipio', 'ciudad', 'estado', 'codigoPostal', 'sucursal_calle', 'correo_1', 'correo_2', 'correo_3', 'sucursal_numero', 'sucursal_colonia', 'sucursal_ciudad', 'sucursal_estado', 'sucursal_codigoPostal', 'banco_1', 'datos_banco_1', 'cuenta_banco_1', 'banco_2', 'datos_banco_2', 'cuenta_banco_2', 'banco_3', 'datos_banco_3', 'cuenta_banco_3'];
//    protected $appends = ['direccion'];
    // protected $hidden = [];
    // protected $dates = [];

    public static $rules = [
        'nombre' => 'required|min:5|max:255',
        'nombre_corto' => 'required|min:5|max:255',
        'rfc' => 'required|unique:empresas',
    ];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
