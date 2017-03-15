<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class EmpresaDataFactura extends Model
{
    use CrudTrait;

    /*
   |--------------------------------------------------------------------------
   | GLOBAL VARIABLES
   |--------------------------------------------------------------------------
   */

    protected $table = 'empresas_data_factura';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['solicitud_factura_id', 'empresa_id', 'nombre', 'descripcion', 'razon', 'rfcl', 'calle', 'n_exterior', 'n_interior', 'colonia', 'estado', 'ciudad', 'municipio', 'delegacion', 'cp', 'correo_1', 'correo_2', 'correo_3'];
//    protected $appends = ['pictureData'];
    // protected $hidden = [];
    // protected $dates = [];

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
    public function facturas()
    {
        return $this->hasMany('App\Models\Factura');
    }

    public function permissions() {
        return $this->belongsToMany( 'Backpack\PermissionManager\app\Models\Permission', 'empresas_permisos' );
    }

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
    //implement the attribute
//    public function getPictureDataAttribute()
//    {
//        return 'holaa';
//    }

    public function asd() {
        return '<a href="/importer/empresa='.$this->id.'" class="btn btn-xs btn-default"><i class="fa fa-code"></i> Importar XML</a>';
    }

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
