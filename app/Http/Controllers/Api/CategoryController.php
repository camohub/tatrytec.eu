<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Entities\Category;
use App\Models\Services\CategoriesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class CategoryController extends BaseController
{

	public function index(Request $request)
	{
		if ( !$request->user()->can('create', Category::class) ) return response()->json(['error' => 'Nemáte oprávnenie upravovať kategórie.']);

		$categories = Category::whereNull('parent_id')->orderBy('sort', 'ASC')->get();

		return response()->json(['categories' => $categories]);
	}


	public function edit( Request $request, CategoriesService $categoriesService, $id )
	{
		$category = Category::where('id', $id)->withTrashed()->first();

		if( !$category ) return response()->json(['error' => 'Kategória nebola nájdená.']);

		if ( !$request->user()->can('update', $category) ) return response()->json(['error' => 'Nemáte oprávnenie upravovať vybranú kategóriu.']);

		return response()->json(['category' => $category]);
	}


	public function store( CategoryRequest $request, CategoriesService $categoriesService, $id = NULL )
	{
		if ( !$id && !$request->user()->can('create', Category::class) ) return response()->json(['error' => 'Nemáte oprávnenie vytvárať a upravovať kategórie.']);
		if ( $id && !$request->user()->can('update', $category = Category::find($id)) ) return response()->json(['error' => 'Nemáte oprávnenie upravovať vybranú kategóriu.']);

		$id ? $categoriesService->updateCatagory($request, $category)
			: $category = $categoriesService->createCatagory($request);

		return response()->json(['id' => $category->id]);
	}


	public function visibility( Request $request, $id )
	{
		$category = Category::where('id', $id)->first();

		if( !$category ) return response()->json(['error' => 'Kategória nebola nájdená.']);

		return response()->json(['error' => 'Nemáte oprávnenie meniť viditeľnosť kategorií.']);

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
			return response()->json(['success' => 'Poradie položiek bolo upravené.']);
		}
		catch ( \Exception $e )
		{
			Log::error($e);
			return response()->json(['error' => 'Pri ukladaní údajov došlo k chybe.']);
		}
	}


	public function getSelectCategories(CategoriesService $categoriesService)
	{
		return response()->json(['selectCategories' => (object)$categoriesService->categoriesToApiSelect()]);
	}

}
