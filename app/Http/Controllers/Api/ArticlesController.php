<?php

namespace App\Http\Controllers\Api;


use App\Exports\ArticlesExport;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\SlimArticleResource;
use App\Models\Entities\Article;
use App\Models\Services\ArticlesService;
use App\Models\Services\ArticlesFilterService;
use App\Models\Services\CategoriesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;


class ArticlesController extends BaseController
{

	const SESS_FILTER = self::class . '_filter';


	public function index(ArticlesFilterService $articlesFilterService)
	{
		$articles = $articlesFilterService->getFilteredArticles()->get();

		return response()->json(['articles' => SlimArticleResource::collection($articles)]);
	}



	public function create( Request $request, CategoriesService $categoriesService )
	{
		if( !$request->user()->can('create', Article::class) )
		{
			flash()->error('Nemáte oprávnenie vytvárať články.')->important();
			return back();
		}

		return view('admin.articles.edit', [
			'article' => NULL,
			'selectCategories' => $categoriesService->categoriesToSelect(),
		]);
	}



	public function edit( Request $request, CategoriesService $categoriesService, $id )
	{
		$article = Article::where('id', $id)->withTrashed()->first();

		if( !$article ) return response()->json(['error' => 'Článok nebol nájdený.']);

		if ( !$request->user()->can('update', $article) ) return response()->json(['error' => 'Nemáte oprávnenie upravovať vybraný článok.']);

		return response()->json([
			'article' => new ArticleResource($article),
			'selectCategories' => $categoriesService->categoriesToSelect(),
		]);
	}


	public function store( ArticleRequest $request, ArticlesService $articlesService, $id = NULL )
	{
		if( !$id && !$request->user()->can('create', Article::class) ) return response()->json(['error' => 'Nemáte oprávnenie vytvárať články.']);
		if ( $id && !$request->user()->can('update', $article = Article::find($id)) ) return response()->json(['error' => 'Nemáte oprávnenie upravovať vybraný článok.']);

		$id ? $articlesService->update($request, $article)
			: $articlesService->create($request);

		return response()->json(['Článok bol uložený do databázy.']);
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


	public function exportArticles()
	{
		return Excel::download(new ArticlesExport(), 'articles-export.xlsx');
	}

}
