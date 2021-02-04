<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Http\Requests\ArticleRequest;
use App\Models\Entities\Article;
use App\Models\Entities\Category;
use App\Models\Services\ArticlesService;
use App\Models\Services\ArticlesFilterService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


class ArticleController extends BaseController
{

	const SESS_FILTER = self::class . '_filter';


	public function index(ArticlesFilterService $articlesFilterService)
	{
		$articles = $articlesFilterService->getFilteredArticles()->get();

		return view('admin.articles.index', ['articles' => $articles]);
	}



	public function create( Request $request )
	{
		if( !$request->user()->can('create', Article::class) )
		{
			flash()->error('Nemáte oprávnenie vytvárať články.')->important();
			return back();
		}

		return view('admin.articles.edit', [
			'article' => NULL,
			'selectCategories' => $this->categoriesToSelect(),
		]);
	}



	public function edit( Request $request, $id )
	{
		$article = Article::where('id', $id)->withTrashed()->first();

		if( !$article )
		{
			flash()->error('Článok nebol nájdený.');
			return back();
		}

		if ( !$request->user()->can('update', $article) )
		{
			flash()->error('Nemáte oprávnenie upravovať vybraný článok.')->important();
			return back();
		}

		return view('admin.articles.edit', [
			'article' => $article,
			'selectCategories' => $this->categoriesToSelect(),
		]);
	}


	public function store( ArticleRequest $request, ArticlesService $articlesService, $id = NULL )
	{
		if( !$id && !$request->user()->can('create', Article::class) )
		{
			flash()->error('Nemáte oprávnenie upravovať vybraný článok.')->important();
			return back()->withInput();
		}

		if ( $id && !$request->user()->can('update', $article = Article::find($id)) )
		{
			flash()->error('Nemáte oprávnenie upravovať vybraný článok.')->important();
			return back()->withInput();
		}

		$id ? $articlesService->update($request, $article) : $articlesService->create($request);

		flash()->success('Článok bol uložený do databázy.');
		return redirect()->route('admin.articles');
	}


	public function visibility( Request $request, $id )
	{
		$article = Article::where('id', $id)->withTrashed()->first();

		if( !$article ) return response()->json(['error' => 'Článok nebol nájdený.']);

		if ( !$request->user()->can('update', $article) ) return response()->json(['error' => 'Nemáte oprávnenie meniť viditeľnosť článku.']);

		$article->visible = !$article->visible;
		$article->save();

		return response()->json(['success' => 'Viditeľnosť článku bola zmenená.']);
	}


	public function delete( Request $request, $id )
	{
		$article = Article::where('id', $id)->withTrashed()->first();

		if ( !$request->user()->can('update', $article) ) return response()->json(['error' => 'Nemáte oprávnenie zmazať vybraný článok.']);

		$article->delete();

		return response()->json(['success' => 'Článok bol zmazaný.']);
	}

//////////////////////////////////////////////////////////////////////////
//// PROTECTED //////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

	/**
	 * @desc produces an array of categories in format required by form->select
	 * @param null|Collection $categories
	 * @param array $result
	 * @param int $lev
	 * @return array
	 */
	public function categoriesToSelect( $categories = NULL, $result = [], $lev = 0 )
	{
		if ( !$categories ) $categories = Category::whereNull('parent_id')->with('allChildren')->orderBy('sort', 'ASC')->get();   // First call.

		foreach ( $categories as $category )
		{
			if ( $category->slug == 'najnovsie' )  continue;

			$result[$category->id] = str_repeat( '>', $lev * 1 ) . $category->name;

			if ( $category->children->count() ) $result = $this->categoriesToSelect( $category->children, $result, $lev + 1 );
		}

		return $result;
	}

}
