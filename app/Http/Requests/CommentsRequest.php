<?php

namespace App\Http\Requests;


use App\Customer;
use Illuminate\Foundation\Http\FormRequest;


class CommentsRequest extends FormRequest
{

	public function rules()
	{
		return [
			'article_id' => 'required',
			'text'       => 'required',
		];
	}

	public function messages()
	{
		return [
			'article_id.required' => 'Systém nevie priradiť komentár ku článku.',
			'text.required'       => 'Napíšte prosím komentár.',
		];
	}

}
