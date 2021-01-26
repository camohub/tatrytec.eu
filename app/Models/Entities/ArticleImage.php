<?php

namespace App\Models\Entities;


use Illuminate\Database\Eloquent\Model;


class ArticleImage extends Model
{

	public $table = 'articles_images';


	public function article()
	{
		return $this->belongsTo(Article::class);
	}
}
