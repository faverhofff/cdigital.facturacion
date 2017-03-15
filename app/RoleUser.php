<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_users';

    public function rol() {
        return $this->hasOne( 'App\Role', 'id', 'role_id' );   
    }    

}
