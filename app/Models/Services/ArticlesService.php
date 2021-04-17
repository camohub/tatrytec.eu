<?php


namespace App\Models\Services;


use App\Http\Requests\ArticleRequest;
use App\Models\Entities\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ArticlesService
{

	public function create(ArticleRequest $request)
	{
		$article = new Article();
		$article->user_id = Auth::user()->id;

		$this->setArticleProperties($request, $article);

		$article->save();

		$article->categories()->attach($request->get('categories'));

		return $article->save();
	}


	public function update(ArticleRequest $request, Article $article)
	{
		$this->setArticleProperties($request, $article);

		$article->categories()->sync($request->get('categories'));

		return $article->save();
	}


	private function setArticleProperties(ArticleRequest $request, Article $article)
	{
		$article->title = $request->get('title');
		$article->slug = Str::slug($request->get('title'));
		$article->meta_desc = $request->get('meta_desc');
		$article->perex = str_replace('<pre>', '<pre class="prettyprint custom">', $request->get('perex'));
		$article->content = str_replace('<pre>', '<pre class="prettyprint custom">', $request->get('content'));
		$article->visible = (bool)$request->get('visible');
	}

}