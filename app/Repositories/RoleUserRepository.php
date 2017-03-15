<?php

namespace App\Repositories;

use App\RoleUser;
use InfyOm\Generator\Common\BaseRepository;

class RoleUserRepository extends BaseRepository {
	/**
	 * @var array
	 */

	/**
	 * Configure the Model
	 **/
	public function model() {
		return RoleUser::class;
	}

	public function deleteRoles($user_id, $exceptRole) {
        RoleUser::where('user_id', '=', $user_id)->where('role_id', '!=', $exceptRole)->delete();
    }
}
