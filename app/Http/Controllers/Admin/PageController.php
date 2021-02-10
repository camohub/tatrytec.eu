<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Models\Entities\Page;
use App\Models\Services\CategoriesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class PageController extends BaseController
{

	public function index()
	{
		$pages = Page::withTrashed()->orderBy('title', 'ASC')->get();

		return view('admin.pages.index', ['pages' => $pages]);
	}



	public function create( Request $request )
	{
		if( !Auth::user()->hasRole('admin') )
		{
			flash()->error('Nemáte oprávnenie vytvárať stránky.')->important();
			return back();
		}

		return view('admin.pages.edit', [
			'page' => NULL,
		]);
	}



	public function edit( Request $request, CategoriesService $categoriesService, $id )
	{
		$page = Page::where('id', $id)->withTrashed()->first();

		if( !$page )
		{
			flash()->error('Stránka nebola nájdená.');
			return back();
		}

		if( !Auth::user()->hasRole('admin') )
		{
			flash()->error('Nemáte oprávnenie upravovať stránky.')->important();
			return back();
		}


		return view('admin.pages.edit', [
			'page' => $page,
		]);
	}


	public function store( Request $request, $id = NULL )
	{
		if( !$id && !Auth::user()->hasRole('admin') )
		{
			flash()->error('Nemáte oprávnenie vytvárať stránky.')->important();
			return back()->withInput();
		}

		if( $id && !$page = Page::find($id) )
		{
			flash()->error('Stránky nebola nájdená.')->important();
			return back()->withInput();
		}

		$page = $page ?? new Page();
		$page->title = $request->get('title');
		$page->slug = Str::slug($page->title);
		$page->content = $request->get('content');
		$page->save();

		flash()->success('Stránka bola uložená do databázy.');
		return redirect()->route('admin.pages');
	}


	public function visibility( Request $request, $id )
	{
		$page = Page::where('id', $id)->withTrashed()->first();

		if( !$page ) return response()->json(['error' => 'Stránka nebola nájdená.']);

		if ( !Auth::user()->hasRole('admin') ) return response()->json(['error' => 'Nemáte oprávnenie meniť viditeľnosť stránky.']);

		$page->visible = !$page->visible;
		$page->save();

		return response()->json(['success' => 'Viditeľnosť stránky bola zmenená.']);
	}


	public function delete( Request $request, $id )
	{
		$page = Page::where('id', $id)->withTrashed()->first();

		if ( !Auth::user()->hasRole('admin') ) return response()->json(['error' => 'Nemáte oprávnenie mazať stránky.']);

		$page->delete();

		return response()->json(['success' => 'Stránka bola zmazaná.']);
	}

}
