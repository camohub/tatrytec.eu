<?php


namespace App\Model\Services;


use App\Http\Requests\ArticleRequest;
use App\Models\Entities\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ArticlesService
{

	public function create(ArticleRequest $request)
	{
		$article = new Article();
		$article->title = $request->get('title');
		$article->slug = Str::slug($request->get('title'));
		$article->meta_desc = $request->get('meta_desc');
		$article->perex = $request->get('perex');
		$article->content = $request->get('content');
		$article->visible = (bool)$request->get('visible');
		$article->user_id = Auth::user()->id;

		$article->save();

		$article->categories()->attach($request->get('categories'));

		return $article->save();
	}


	public function update(ArticleRequest $request, Article $article)
	{
		$article->title = $request->get('title');
		$article->slug = Str::slug($request->get('title'));
		$article->meta_desc = $request->get('meta_desc');
		$article->perex = $request->get('perex');
		$article->content = $request->get('content');
		$article->visible = (bool)$request->get('visible');

		$article->categories()->sync($request->get('categories'));

		return $article->save();
	}

}