<?php

namespace App\Http\Controllers;


use App\Http\Requests\CommentsRequest;
use App\Models\Entities\Article;
use App\Models\Entities\Category;
use App\Models\Entities\Comment;
use App\Models\Services\CommentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class HomepageController extends BaseController
{


	public function index(Request $request, $slug = NULL)
	{
		return view('homepage.index', []);
	}

	public function about(Request $request, $slug = NULL)
	{
		return view('homepage.about', []);
	}

	public function contact(Request $request, $slug = NULL)
	{
		return view('homepage.contact', []);
	}
}
