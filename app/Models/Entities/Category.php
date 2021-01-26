<?php

namespace App\Models\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
	use SoftDeletes;

	protected $fillable = [];

	protected $hidden = [];

	protected $casts = [];

	protected $with = ['children'];


	public function children()
	{
		return $this->hasMany( Category::class, 'parent_id' )->visible();
	}


	public function allChildren()
	{
		return $this->hasMany( Category::class, 'parent_id' );
	}


	public function articles()
	{
		return $this->belongsToMany(Article::class)->visible();
	}


	public function allArticles()
	{
		return $this->belongsToMany(Article::class);
	}

	public function scopeVisible($query)
	{
		return $query->where('visible', TRUE);
	}


	public function getCategoryIds( array $ids = [] )
	{
		$ids[] = $this->id;

		if ( $this->children->count() )
		{
			foreach ( $this->children as $child ) $ids[] = $this->getCategoryIds( $child, $ids );
		}

		return $ids;
	}
}
