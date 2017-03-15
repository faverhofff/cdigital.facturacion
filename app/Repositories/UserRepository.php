<?php

namespace App\Repositories;

use App\Models\Concepto;
use App\User;
use Illuminate\Support\Facades\DB;
use InfyOm\Generator\Common\BaseRepository;

class UserRepository extends BaseRepository {
	/**
	 * @var array
	 */

	/**
	 * Configure the Model
	 **/
	public function model() {
		return User::class;
	}

    public function getPromotores() {
        return DB::table('users')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->select('users.*')
            ->where('roles.name', '=', 'Cliente Promotor')
            ->get();
    }

    public function getPromotor($promotor_id) {
        return DB::table('users')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->select('users.*')
            ->where('users.id', '=', $promotor_id)
            ->where('roles.name', '=', 'Cliente Promotor')
            ->get();
    }
}
