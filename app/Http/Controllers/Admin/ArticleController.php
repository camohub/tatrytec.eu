<?php

namespace App\Http\Controllers\Admin;


use App\Models\Entities\Article;

class ArticleController extends BaseController
{

	public function index()
	{
		$articles = Article::with(['comments', 'user'])->get();
		return view('article.index', compact('articles'));
	}
}
