<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class DiarioSalida extends Model
{
    use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'diario_salida';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['movimiento','factura','cliente_id','cliente_promotor_id','deposito','subtotal','regcte','regprov','regctep','regprovp','compdesp','sofom','fecha_depo','empresa_id', 'user_id'];
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
    public function empresa() {
        return $this->hasOne( 'App\Models\EmpresaDataFactura', 'solicitud_factura_id', 'id' );   
    }

    public function empresaReal() {
        return $this->hasOne( 'App\Models\Empresa', 'id', 'empresa_id' );   
    }

    public function cliente() {
        return $this->hasOne( 'App\Models\Cliente', 'id', 'cliente_id' );   
    }

    public function clientePromotor() {
        return $this->hasOne( 'App\Models\ClientePromotor', 'id', 'cliente_promotor_id' );   
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

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
