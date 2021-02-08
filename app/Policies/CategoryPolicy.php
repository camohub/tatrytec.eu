<?php

namespace App\Policies;


use App\Models\Entities\Article;
use App\Models\Entities\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class CategoryPolicy
{

	use HandlesAuthorization;


	public function create(User $user)
	{
		return $user->hasRole([Role::ROLE_ADMIN, Role::ROLE_REDACTOR]);
	}
}
