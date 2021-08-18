<?php

namespace App\Policies;


use App\Models\Entities\Category;
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


	public function update(User $user, Category $category)
	{
		return $user->hasRole(Role::ROLE_ADMIN) || $user->id === $category->user_id;
	}
}
