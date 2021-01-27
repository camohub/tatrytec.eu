<?php

namespace App\Http\Controllers;


use App\Mail\RegisterEmailConfirmation;
use App\Models\Entities\Article;
use App\Models\Entities\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends BaseController
{

	const SESS_ID = self::class . '_ID';

	const PAGE_ITEMS = 7;


	public function index(Request $request, $slug = NULL)
	{
		$slug = $slug ?: 'najnovsie';

		if( $category = Category::where('slug', $slug)->first() )  // Displays category.
		{
			session([self::SESS_ID => $category->id]);

			$articles = $this->getArticles($category->getCategoryIds());

			$view = [
				'articles' => $articles,
				'category_id' => $category->id,
				'metaDesc' => $category->name,
				'title' => $category->name,
			];

		}
		else // Displays one article.
		{
			if ( ! $article = Article::where('slug', $slug)->first() ) abort(404);

			$view = [
				'category_id' => session(self::SESS_ID),
				'article' => $article,
				'comments' => $article->comments()->paginate(2, ['*'], 'komentare')->onEachSide(1),
				'fb' => TRUE,
				'google' => TRUE,
				'metaDesc' => $article->meta_desc,
				'title' => $article->title,
			];
		}

		return view('article.index', $view);
	}


	protected function getArticles($categoriesIds)
	{
		$articles = Article::select('articles.*')
			->visible()
			->join('articles_categories', function ($join) use ($categoriesIds) {
				$join->on('articles.id', '=', 'articles_categories.article_id')
					->whereIn('articles_categories.category_id', $categoriesIds);
			})
			->orderBy('id', 'DESC');

		return $articles->paginate(self::PAGE_ITEMS)->onEachSide(1);
	}
}
