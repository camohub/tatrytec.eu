<?php

namespace App\Models\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Comment extends Model
{
	use SoftDeletes;

	public function article()
	{
		return $this->belongsTo(Article::class);
	}
}
