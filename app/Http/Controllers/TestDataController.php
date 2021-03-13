<?php


namespace App\Http\Controllers;


use App\Models\Entities\Article;


class TestDataController extends BaseController
{

	protected $testTitle = 'Test text';


	public function index()
	{
		Article::where('title', 'like', '%' . $this->testTitle . '%' )->first()->forceDelete();
	}

}
