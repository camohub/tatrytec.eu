<?php

namespace App\Http\Requests;


use App\Models\Entities\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;


class CategoryRequest extends FormRequest
{

	public function rules()
	{
		return [
			'id' => 'nullable|integer',
			'name' => 'required|max:255',
			'parent_id' => 'nullable|integer',
		];
	}

	public function messages()
	{
		return [
			'id' => 'Kategoria nemá platné id',
			'name.required' => 'Vyplňte prosím názov.',
			'name.max' => 'Názov môže mať max. 255 znakov.',
			'parent_id.integer' => 'Nadradená kategória nemá platné ID.'
		];
	}

	/**
	 * @param $validator
	 */
	public function withValidator(Validator $validator)
	{
		$validator->after(function ($validator)
		{
			$id = $this->get('id');
			$parent_id = $this->get('parent_id');
			if( $id && Category::where('name', $this->get('name'))->where('id', '!=', $id)->first() )
			{
				$validator->errors()->add('name', 'Kategória s rovnakým názvom už existuje.');
			}
			if( $id && $id == $parent_id )
			{
				$validator->errors()->add('name', 'Kategória nemôže byť priradená sama sebe.');
			}
			if( !$id && Category::where('name', $this->get('name'))->first() )
			{
				$validator->errors()->add('name', 'Kategória s rovnakým názvom už existuje.');
			}
		});

		if( $validator->fails() ) session()->flash('showModal', 'editCategoryFormModal');
	}

}
