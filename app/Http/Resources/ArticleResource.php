<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'title' => $this->title,
			'meta_desc' => $this->meta_desc,
			'perex' => $this->perex,
			'content' => $this->content,
			'visible' => $this->visible,
			'created_at' => $this->created_at->getTimestamp(),
			'user' => [
				'id' => $this->user->id,
				'name' => $this->user->name,
				'email' => $this->user->email,
			],
			'categories' => $this->categories->map(function($cat) { return $cat->id; }),
			'fullCategories' => CategoryResource::collection($this->categories),
		];
	}
}
