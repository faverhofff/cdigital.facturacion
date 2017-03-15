<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 18/02/2017
 * Time: 23:55
 */

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;


class UserEmpresaPermiso extends Model
{
    use CrudTrait;
    //

    protected $table = 'users_empresas_permisos';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'empresa_id',
        'permission_id'
    ];

    public static $rules = [
        'user_id' => 'required|unique_with:users_empresas_permisos, empresa_id, permission_id',
        'empresa_id' => 'required',
        'permission_id' => '',
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function empresa()
    {
        return $this->hasOne('App\Models\Empresa', 'id', 'empresa_id');
    }

    public function permission()
    {
        return $this->hasOne('Backpack\PermissionManager\app\Models\Permission', 'id', 'permission_id');
    }
}