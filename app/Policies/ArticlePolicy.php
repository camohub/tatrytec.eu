<?php

namespace App\Policies;


use App\Models\Entities\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class ArticlePolicy
{

    use HandlesAuthorization;


    public function __construct()
    {

    }


	public function update(User $user, Article $article)
	{
		return $user->hasRole('admin') || $user->id === $article->user_id;
	}
}
