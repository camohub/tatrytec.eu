<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

	protected $token;


	public function __construct( $resource, $token = NULL )
	{
		parent::__construct($resource);
		$this->token = $token;
	}

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
			'name' => $this->name,
			'email' => $this->email,
			'token' => $this->token,
			'created_at' => $this->created_at->getTimestamp(),
			'deleted_at' => $this->deleted_at ? $this->deleted_at->getTimestamp() : NULL,
			'roles' => $this->roles->map(function ($role) { return $role->id; }),
		];
	}
}
