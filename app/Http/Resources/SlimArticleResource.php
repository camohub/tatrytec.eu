<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SlimArticleResource extends JsonResource
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
			'user' => ['id' => $this->user->id, 'name' => $this->user->name, 'email' => $this->user->email],
			'visible' => $this->visible,
			'created_at' => $this->created_at->getTimestamp(),
		];
	}
}
