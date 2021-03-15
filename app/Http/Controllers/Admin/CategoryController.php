<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\CategoryRequest;
use App\Models\Entities\Article;
use App\Models\Entities\Category;
use App\Models\Services\ArticlesService;
use App\Models\Services\ArticlesFilterService;
use App\Models\Services\CategoriesService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CategoryController extends BaseController
{

	public function index(Request $request, CategoriesService $categoriesService)
	{
		if ( !$request->user()->can('create', Category::class) )
		{
			flash()->error('Nemáte oprávnenie upravovať kategórie.');
			return back();
		};

		$categories = Category::whereNull('parent_id')
			->with('allChildren')
			->without('children')
			->orderBy('sort', 'ASC')->get();
		$categoriesToSelect = $categoriesService->categoriesToSelect();

		return view('admin.categories.index', ['categories' => $categories, 'categoriesToSelect' => $categoriesToSelect]);
	}


	public function store( CategoryRequest $request, CategoriesService $categoriesService )
	{
		$id = $request->get('id', NULL);

		if ( !$request->user()->can('create', Category::class) )
		{
			flash()->error('Nemáte oprávnenie vytvárať a upravovať kategórie.')->important();
			return back()->withInput();
		}

		$id ? $categoriesService->updateCatagory($request, Category::find($id)) : $categoriesService->createCatagory($request);

		flash()->success('Kategória bola uložená do databázy.');
		return redirect()->route('admin.categories');
	}


	public function visibility( Request $request, $id )
	{
		$category = Category::where('id', $id)->first();

		if( !$category ) return response()->json(['error' => 'Kategória nebola nájdená.']);

		if ( !$request->user()->can('create', Category::class) ) return response()->json(['error' => 'Nemáte oprávnenie meniť viditeľnosť kategorií.']);

		$category->visible = !$category->visible;
		$category->save();

		return response()->json(['success' => 'Viditeľnosť kategórie bola zmenená.']);
	}


	public function delete( Request $request, $id )
	{
		$category = Category::where('id', $id)->first();

		if ( !$request->user()->can('create', Category::class) ) return response()->json(['error' => 'Nemáte oprávnenie zmazať kategóriu.']);

		$category->delete();

		return response()->json(['success' => 'Kategória bola zmazaná.']);
	}


	public function sort(Request $request, CategoriesService $categoriesService)
	{
		try
		{
			$categoriesService->updateCategoriesSort( $_GET['menuItem'] );
			//$this->cleanCache();

			flash()->success('Poradie položiek bolo upravené.');
		}
		catch ( \Exception $e )
		{
			Log::error($e);
			flash()->error('Pri ukladaní údajov došlo k chybe.');
		}

		return back();
	}

}
