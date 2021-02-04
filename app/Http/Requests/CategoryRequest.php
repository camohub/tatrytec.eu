<?php

namespace App\Http\Requests;


use App\Customer;
use Illuminate\Foundation\Http\FormRequest;


class CategoryRequest extends FormRequest
{

	public function rules()
	{
		return [
			'title' => 'required|max:255',
			'meta_desc' => 'required|max:255',
			'perex' => 'required',
			'content' => 'required',
			'categories' => 'required',
		];
	}

	public function messages()
	{
		return [
			'title.required' => 'Vyplňte prosím nadpis.',
			'title.max' => 'Nadpis môže mať max. 255 znakov.',
			'meta_desc.required' => 'Vyplňte prosím meta desc.',
			'meta_desc.max' => 'Pole meta desc môže mať max. 255 znakov.',
			'perex.required' => 'Vyplňte prosím perex.',
			'perex.content' => 'Vyplňte prosím text.',
			'categories.required' => 'Vyberte prosím aspoň jednu kategóriu.',
		];
	}

}
