<?php


namespace App\Http\Controllers;


use App\Models\Entities\Article;
use App\Models\Entities\Category;
use App\Models\Entities\Comment;
use App\Models\User;


class TestDataController extends BaseController
{

	protected $articleTitle = 'Selenium test';

	protected $categoryName = 'Selenium test';


	public function index()
	{
		$testUser = User::where('email', config('test.test_user_email'))->where('resource', 'github')->first();
		if($testUser) $testUser->forceDelete();

		$article = Article::where('title', 'like', $this->articleTitle . '%')->first();
		if($article) $article->forceDelete();


		$category = Category::where('name', 'like', $this->categoryName . '%')->whereNotNull('parent_id')->first();
		if( $category ) $category->forceDelete();

		$category = Category::where('name', 'like', $this->categoryName . '%')->first();
		if( $category ) $category->forceDelete();


		Comment::where('user_id', 20)->forceDelete();

		return response()->json(['success' => 'Test data was successfully deleted.']);
	}

}
