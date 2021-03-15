<?php


namespace App\Http\Controllers;


use App\Models\Entities\Article;


class TestDataController extends BaseController
{

	protected $articleTitle = 'Test text';

	protected $categoryName = 'Test text';


	public function index()
	{
		if( $article = Article::where('title', 'like', $this->articleTitle . '%' ) ) $article->first();
		if( $category = Category::where('name', 'like', $this->categoryName . '%' ) ) $article->first();
	}

}
