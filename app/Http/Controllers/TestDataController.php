<?php


namespace App\Http\Controllers;


use App\Models\Entities\Article;
use App\Models\Entities\Category;


class TestDataController extends BaseController
{

	protected $articleTitle = 'Selenium test';

	protected $categoryName = 'Selenium test';


	public function index()
	{
		$article = Article::where('title', 'like', $this->articleTitle . '%' )->first();
		if($article) $article->forceDelete();


		$category = Category::where('name', 'like', $this->categoryName . '%' )->whereNotNull('parent_id')->first();
		if( $category ) $category->forceDelete();
		$category = Category::where('name', 'like', $this->categoryName . '%')->first();
		if( $category ) $category->forceDelete();
	}

}
