<?php

namespace App\Models\Services;


use App\Attribute;
use App\Category;
use App\ModelData;
use App\Models\Entities\Article;
use App\Product;
use Illuminate\Http\Request;


class ArticlesFilterService
{

	const SESS_FILTER = self::class . '_filter';

	/** @var  Request */
	public $request;


	public function __construct(Request $r)
	{
		$this->request = $r;
	}


	public function getFilteredArticles()
	{
		$title = $this->request->get('title');
		$users = $this->request->get('users');
		$interval = $this->request->get('interval');
		$sort = $this->request->get('sort');

		// Default articles builder
		$articles = Article::select('articles.*')->withTrashed();

		$this->setSession();

		//////////////////////////////////////////////////////////////////////////////////
		//////// FILTERS ////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////

		if( $title )
		{
			$articles = $this->addTitleFilter($articles, $title);
		}

		if( $users )
		{
			$articles = $this->addUserFilter($articles, $users);
		}

		if( $interval )
		{
			$articles = $this->addIntervalFilter($articles, $interval);
		}

		//////////////////////////////////////////////////////////////////////////////////
		///// sort //////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////

		$articles = $this->addSort($articles, $sort);


		return $articles;
	}

///////////////////////////////////////////////////////////////////////////////////////////
//// PRIVATE /////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

	private function addTitleFilter($articles, string $title)
	{
		return $articles->where('title', 'LIKE', '%' . $title . '%');
	}


	private function addUserFilter($products, array $users)
	{
		return $products->whereIn('user_id', $users);
	}

	private function addIntervalFilter($articles, int $interval)
	{
		return $articles->where('created_at', '<', date('Y-m-d H:i:s', time() - $interval * 60 * 60 * 24));
	}


	private function addSort($articles, $sort)
	{
		switch ($sort) {
			case "title ASC":
				return $articles->orderBy('title', 'asc');
			case "title DESC":
				return $articles->orderBy('title', 'asc');
			case "user.name ASC":
				return $articles->orderBy('user.name', 'asc');
			case "user.name DESC":
				return $articles->orderBy('user.name', 'asc');
			case "created_at ASC":
				return $articles->orderBy('id', 'asc');
			case "created_at DESC":
				return $articles->orderBy('id', 'desc');
			default:
				return $articles->orderBy('id', 'desc');
		}
	}


	private function setSession()
	{
		$title = $this->request->get('title');
		$users = $this->request->get('users');
		$interval = $this->request->get('interval');
		$sort = $this->request->get('sort');

		$remember = $this->request->get('remember');

		$filter = [
			'title' => $remember ? $title : NULL,
			'users' => $remember ? $users : [],
			'interval' => $remember ? $interval : NULL,
			'sort' => $remember ? $sort : [],
			'remember' => $remember ? $remember : NULL,
		];

		session([self::SESS_FILTER => (object)$filter]);
	}

}


