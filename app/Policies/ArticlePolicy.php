<?php

namespace App\Policies;


use App\Models\Entities\Article;
use App\Models\Entities\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class ArticlePolicy
{

    use HandlesAuthorization;


    public function __construct()
    {

    }


	public function create(User $user)
	{
		return $user->hasRole([Role::ROLE_ADMIN, Role::ROLE_REDACTOR]);
	}


	public function update(User $user, Article $article)
	{
		return $user->hasRole(Role::ROLE_ADMIN) || $user->id === $article->user_id;
	}
}
