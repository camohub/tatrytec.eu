<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Models\Entities\Article;
use Illuminate\Http\Request;


class CommentController extends BaseController
{

	public function index( Request $request, $article_id )
	{
		if( !$article = Article::find($article_id) )
		{
			flash()->error('Článok nebol nájdený.');
			return back();
		}

		if ( !$request->user()->can('update', $article) )
		{
			flash()->error('Nemáte oprávnenie upravovať vybraný článok.')->important();
			return back();
		}

		return view('admin.comments.index', [
			'article' => $article,
			'comments' => $article->comments()->withTrashed()->paginate(15)->onEachSide(1)
		]);
	}


	public function delete( Request $request, $article_id, $comment_id )
	{
		if( !$article = Article::withTrashed()->find($article_id) )
		{
			return response()->json(['error' => 'Článok nebol nájdený.']);
		}
		if( !$comment = $article->comments()->withTrashed()->where('id', $comment_id)->first() )
		{
			return response()->json(['error' => 'Komentár nebol nájdený.']);
		}
		if ( !$request->user()->can('update', $article) )
		{
			return response()->json(['error' => 'Nemáte oprávnenie skrývať komentáre ku článku.']);
		}

		$comment->deleted_at = $comment->deleted_at ? NULL : new \DateTimeImmutable();
		$comment->save();

		return response()->json(['success' => 'Viditeľnosť komentára bola zmenená.']);
	}

}
