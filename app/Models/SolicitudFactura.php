<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class SolicitudFactura extends Model
{
    use CrudTrait;
    //

    protected $table = 'solicitudes_factura';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = [
        'folio',
        'empresa_id',
        'user_id',
        'resumen',
        'forma_pago',
        'metodo_pago',
        'digito',
        'factura',
        'movimiento'
    ];

    public static $rules = [
        'folio' => 'required|unique:folio',
        'empresa_id' => 'required',
        'user_id' => 'required',
        'resumen' => '',
        'forma_pago' => '',
        'metodo_pago' => '',
        'digito' => '',
        'factura' => '',
        'movimiento' => ''
    ];

    public function getEmpresaName() {
        if ($this->empresaReal->nombre=='') {
            if($this->empresa != null)
                return $this->empresa->nombre;
        } else return $this->empresaReal->nombre;
    }

    public function getRazon() {
        if ($this->empresaReal->razon=='') {
            if($this->empresa != null)
                return $this->empresa->razon;
        } else return $this->empresaReal->razon;
    }

    public function getRFCL() {
        if ($this->empresaReal->rfc=='') {
            if($this->empresa != null)
                return $this->empresa->rfcl;
        } else return $this->empresaReal->rfc;
    }

    public function getCalle() {
        if ($this->empresaReal->calle=='') {
            if($this->empresa != null)
                return $this->empresa->calle;
        } else return $this->empresaReal->calle;
    }

    public function getNExterior() {
        if ($this->empresaReal->noExterior=='') {
            if($this->empresa != null)
                return $this->empresa->n_exterior;
        } else return $this->empresaReal->noExterior;
    }

    public function getNInterior() {
        if ($this->empresaReal->noInterior=='') {
            if($this->empresa != null)
                return $this->empresa->n_interior;
        } else return $this->empresaReal->noInterior;
    }    

    public function getColonia() {
        if ($this->empresaReal->colonia=='') {
            if($this->empresa != null)
                return $this->empresa->colonia;
        } else return $this->empresaReal->colonia;
    }    

    public function getEstado() {
        if ($this->empresaReal->estado=='') {
            if($this->empresa != null)
                return $this->empresa->estado;
        } else return $this->empresaReal->estado;
    }   

    public function getCiudad() {
        if ($this->empresaReal->ciudad=='') {
            if($this->empresa != null)
                return $this->empresa->ciudad;
        } else return $this->empresaReal->ciudad;
    }   

    public function getMunicipio() {
        if ($this->empresaReal->municipio=='') {
            if($this->empresa != null)
                return $this->empresa->municipio;
        } else return $this->empresaReal->municipio;
    } 

    public function getDelegacion() {
        if ($this->empresaReal->delegacion=='') {
            if($this->empresa != null)
                return $this->empresa->delegacion;
        } else return $this->empresaReal->delegacion;
    }

    public function getCP() {
        if ($this->empresaReal->codigoPostal=='') {
            if($this->empresa != null)
                return $this->empresa->cp;
        } else return $this->empresaReal->codigoPostal;
    }

    public function getCorreo1() {
        if ($this->empresaReal->correo_1=='') {
            if($this->empresa != null)
                return $this->empresa->correo_1;
        } else return $this->empresaReal->correo_1;
    }

    public function getCorreo2() {
        if ($this->empresaReal->correo_2=='') {
            if($this->empresa != null)
                return $this->empresa->correo_2;
        } else return $this->empresaReal->correo_2;
    }

    public function getCorreo3() {
        if ($this->empresaReal->correo_3=='') {
            if($this->empresa != null)
                return $this->empresa->correo_3;
        } else return $this->empresaReal->correo_3;
    }

    public function getSubtotal() {
        $_s = 0;
        // foreach ($this->facturas()->get() as $key => $value) {
        //     foreach ($value->conceptos()->get() as $item) {
        //         $_s+=$item->importe;
        //     }
        // }

        return $_s;
    }

    public function user() {
        return $this->hasOne( 'App\User', 'id', 'user_id' );
    }

    public function empresa() {
        return $this->hasOne( 'App\Models\EmpresaDataFactura', 'solicitud_factura_id', 'id' );   
    }

    public function empresaReal() {
        return $this->hasOne( 'App\Models\Empresa', 'id', 'empresa_id' );   
    }
}
