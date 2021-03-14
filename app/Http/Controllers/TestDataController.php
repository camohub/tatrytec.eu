<?php


namespace App\Http\Controllers;


use App\Models\Entities\Article;


class TestDataController extends BaseController
{

	protected $testTitle = 'Test text';


	public function index()
	{
		if( $article = Article::where('title', 'like', $this->testTitle . '%' ) ) $article->first();
	}

}
