<?php

namespace App\Http\Requests;


use App\Customer;
use Illuminate\Foundation\Http\FormRequest;


class ImageRequest extends FormRequest
{

	public function rules()
	{
		return [
			'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:5120',  // 5MB
		];
	}

	public function messages()
	{
		return [
			'image.required' => 'Nevybrali ste obrázok.',
			'image.mimes' => 'Súbor nemá povolený formát jpg|png|gif|svg.',
			'image.max' => 'Súbor nesmie mať viac ako 5MB.',
		];
	}

}
