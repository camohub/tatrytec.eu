<?php

namespace App\Http\Controllers\Admin;


use App\Exports\ArticlesExport;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ArticleRequest;
use App\Models\Entities\Article;
use App\Models\Services\ArticlesService;
use App\Models\Services\ArticlesFilterService;
use App\Models\Services\CategoriesService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ArticleController extends BaseController
{

	const SESS_FILTER = self::class . '_filter';


	public function index(ArticlesFilterService $articlesFilterService)
	{
		$articles = $articlesFilterService->getFilteredArticles()->get();

		$grid = new Datagrid(Article::with('user'));
		$grid->addColumn('id')
			->setSort();

		$grid->addColumn('title')
			->setSort();

		$grid->addColumn('created_at', 'Created')
			->setRender(function($value, $item) {
				return '<b>' . $value->format('d.m.Y H:i') . '</b>';
			})
			->setNoEscape()
			->setSort();

		$grid->addColumn('visible', 'Visible')
			->setOutherClass(function($value, $item) {
				return $value ? 'bg-success' : 'bg-danger';
			});

		$grid->addColumn('user.name', 'User');
		$grid->addColumn('user.roles', 'Roles')
			->setRender(function($value, $item) {
				return $value->map( function($value) { return $value->name; } )->join(', ');
			});

		$grid->addColumn('', '', Column::TYPE_CUSTOM)
			->setNoEscape()
			->setRender(function($value, $item) {
				return '
					<a href="' . route('admin.articles.edit', ['id' => $item->id]) . '">edit</a>
					<a href="' . route('admin.articles.visibility', ['id' => $item->id]) . '">visibility</a>
					<a href="' . route('admin.articles.delete', ['id' => $item->id]) . '" class="text-danger">visibility</a>
				';
			});

		return view('admin.articles.index', ['articles' => $articles, 'grid' => $grid]);
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
			'selectCategories' => $categoriesService->categoriesToSelect(),
		]);
	}


	public function store( ArticleRequest $request, ArticlesService $articlesService, $id = NULL )
	{
		if( !$id && !$request->user()->can('create', Article::class) )
		{
			flash()->error('Nemáte oprávnenie vytvárať články.')->important();
			return back()->withInput();
		}

		if ( $id && !$request->user()->can('update', $article = Article::find($id)) )
		{
			flash()->error('Nemáte oprávnenie upravovať vybraný článok.')->important();
			return back()->withInput();
		}

		$id ? $articlesService->update($request, $article)
			: $articlesService->create($request);

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


	public function exportArticles()
	{
		return Excel::download(new ArticlesExport(), 'articles-export.xlsx');
	}

}
