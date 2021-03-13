<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\BaseController;
use App\Models\Entities\Article;


class UserController extends BaseController
{

	protected $testTitle = 'Test text';


	public function index()
	{
		Article::where('title', 'like', '%' . $this->testTitle . '%' )->first()->forceDelete();
	}

}
