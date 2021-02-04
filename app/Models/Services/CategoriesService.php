<?php

namespace App\Models\Services;


use App\Http\Requests\CommentsRequest;
use App\Models\Entities\Comment;
use App\ProductComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoriesService
{

	/** @var  Request */
	public $request;


	public function __construct( Request $r )
	{
		$this->request = $r;
	}


	public function createComment( CommentsRequest $request )
	{
		$user = Auth::user();

		$comment = new Comment();
		$comment->text = $this->cleanAndFormatText($request->text);
		$comment->article_id = $request->article_id;
		$comment->user_id = $user->id;
		$comment->user_name = $user->name;
		$comment->email = $user->email;

		$comment->save();
	}


	protected function cleanAndFormatText($text)
	{
		$text = strip_tags($text);
		$text = htmlspecialchars($text, ENT_QUOTES | ENT_HTML401);
		$text = preg_replace('/\*([^*]+)\*/', '<b>$1</b>', $text);
		$text = preg_replace_callback('/```([^`]+)```/', function($m) {
			return '<pre class="prettyprint custom"><code>' . trim($m[1], "\r\n") . '</code></pre>';
		}, $text);

		return $text;
	}

}


