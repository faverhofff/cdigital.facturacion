<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class ConceptoVirtual extends Model
{
    use CrudTrait;
    //

    protected $table = 'conceptos_virtual';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = [
        'cantidad',
        'unidad',
        'noIdentificacion',
        'descripcion',
        'valorUnitario',
        'importe',
        'factura_id',
        'solfactura'
    ];

    public static $rules = [
        'cantidad' => 'required',
        'unidad' => 'required',
        'descripcion' => 'required',
        'valorUnitario' => 'required',
        'importe' => 'required',
        'factura_id' => 'required',
    ];

    public function factura() {
        return $this->hasOne( 'App\Models\Factura', 'id', 'factura_id' );
    }
}
