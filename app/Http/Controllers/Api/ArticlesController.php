<?php

namespace App\Http\Controllers\Api;


use App\Exports\ArticlesExport;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\SlimArticleResource;
use App\Models\Entities\Article;
use App\Models\Entities\Role;
use App\Models\Services\ArticlesService;
use App\Models\Services\ArticlesFilterService;
use App\Models\Services\CategoriesService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ArticlesController extends BaseController
{

	public function index(ArticlesFilterService $articlesFilterService)
	{
		$articles = $articlesFilterService->getFilteredArticles()->get();

		return response()->json(['articles' => SlimArticleResource::collection($articles)]);
	}


	public function edit( Request $request, CategoriesService $categoriesService, $id )
	{
		$article = Article::where('id', $id)->withTrashed()->first();

		if( !$article ) return response()->json(['error' => 'Článok nebol nájdený.']);

		if ( !$request->user()->can('update', $article) ) return response()->json(['error' => 'Nemáte oprávnenie upravovať vybraný článok.']);

		return response()->json(['article' => new ArticleResource($article)]);
	}


	public function store( ArticleRequest $request, ArticlesService $articlesService, $id = NULL )
	{
		if( !$id && !$request->user()->can('create', Article::class) ) return response()->json(['error' => 'Nemáte oprávnenie vytvárať články.']);
		if ( $id && !$request->user()->can('update', $article = Article::find($id)) ) return response()->json(['error' => 'Nemáte oprávnenie upravovať vybraný článok.']);

		$id ? $articlesService->update($request, $article)
			: $article = $articlesService->create($request);

		return response()->json(['id' => $article->id]);
	}


	public function visibility( Request $request, $id )
	{
		$article = Article::where('id', $id)->withTrashed()->first();

		if( !$article ) return response()->json(['error' => 'Článok nebol nájdený.']);

		if ( !$request->user()->hasRole(Role::ROLE_ADMIN) ) return response()->json(['error' => 'Nemáte oprávnenie meniť viditeľnosť článku.']);

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
