<?php

namespace App\Models\Entities;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Comment extends Model
{

	use SoftDeletes;


	protected $appends = [ 'created' ];


	public function article()
	{
		return $this->belongsTo(Article::class);
	}


	public function user()
	{
		return $this->belongsTo(User::class);
	}


	public function getCreatedAttribute()
	{
		return $this->created_at->format( 'd.m.Y H:i:s' );
	}
}
