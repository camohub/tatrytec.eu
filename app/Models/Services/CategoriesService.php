<?php

namespace App\Models\Services;


use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CommentsRequest;
use App\Models\Entities\Category;
use App\Models\Entities\Comment;
use App\ProductComment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoriesService
{

	/** @var  Request */
	public $request;


	public function __construct( Request $r )
	{
		$this->request = $r;
	}


	public function updateCategoriesSort($categoriesArray)
	{
		$i = 1;
		foreach ( $categoriesArray as $key => $val )
		{
			DB::table('categories')->where('id', (int)$key)
				->update(['sort' => ++$i, 'parent_id' => !$val ? NULL : (int)$val]);
		}
	}


	public function createCatagory( CategoryRequest $request )
	{
		$category = new Category();
		$category->name = $request->get('name');
		$category->slug = Str::slug($category->name);
		$category->sort = 0;
		$category->parent_id = $request->get('parent_id', NULL);
		$category->visible = FALSE;

		return $category->save();
	}


	public function updateCatagory( CategoryRequest $request, Category $category )
	{
		$category->name = $request->get('name');
		$category->slug = Str::slug($category->name);
		$category->parent_id = $request->get('parent_id', NULL);

		return $category->save();
	}


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


