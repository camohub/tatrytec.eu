<?php

namespace App\Http\Controllers;


use App\Http\Requests\CommentsRequest;
use App\Models\Entities\Article;
use App\Models\Entities\Category;
use App\Models\Entities\Comment;
use App\Models\Entities\Page;
use App\Models\Services\CommentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class PageController extends BaseController
{

	public function index($page)
	{
		if( !$page = Page::where('slug', $page)->first() ) abort(404);

		return view('page.index', ['page' => $page]);
	}

}
