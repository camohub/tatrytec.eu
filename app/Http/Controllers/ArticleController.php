<?php

namespace App\Http\Controllers;


use App\Http\Requests\CommentsRequest;
use App\Models\Entities\Article;
use App\Models\Entities\Category;
use App\Models\Entities\Comment;
use App\Models\Services\CommentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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

			$articles = $this->getCategoryArticles($category);

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
				//'comments' => $article->comments()->paginate(15, ['*'], 'komentare')->onEachSide(1),
				'fb' => TRUE,
				'google' => TRUE,
				'metaDesc' => $article->meta_desc,
				'title' => $article->title,
			];
		}

		return view('article.index', $view);
	}


	public function addComment( CommentsRequest $request, CommentsService $commentService )
	{
		try
		{
			$commentService->createComment( $request );
			$result = ['success' => 'Komentár bol pridaný.'];
		}
		catch ( \Exception $e )
		{
			Log::error($e);
			$result = ['error' => 'Pri ukladaní došlo k chybe. Skúste to prosím ešte raz, alebo kontaktujte administrátora.'];
		}

		return response()->json($result);
	}


	public function showComments( Request $request )
	{
		$articleId = $request->get( 'articleId' );

		$comments = Comment::where('article_id', $articleId)
			->with('user')
			->orderBy('id', 'desc')
			->paginate(15)
			->onEachSide(1)
			->setPath(route('show-comments'));

		if ( $request->ajax() )
		{
			return response()->json( [
				'comments'   => $comments,
				'pagination' => $comments->appends( request()->query() ) . "",
			], 200 );
		}
	}


	protected function getCategoryArticles( Category $category )
	{
		if( $category->slug == 'najnovsie' )
		{
			$articles = Article::visible()->orderBy('id', 'DESC');
		}
		else
		{
			$categoriesIds = $category->getCategoryIds();

			$articles = Article::select('articles.*')
				->visible()
				->join('articles_categories', function ($join) use ($categoriesIds) {
					$join->on('articles.id', '=', 'articles_categories.article_id')
						->whereIn('articles_categories.category_id', $categoriesIds);
				})
				->orderBy('id', 'DESC');
		}

		return $articles->paginate(self::PAGE_ITEMS)->onEachSide(1);
	}
}
