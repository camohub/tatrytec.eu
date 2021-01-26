<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class RegisterUser extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'email' => 'required|email|unique:users|max:30',
			'name' => 'required|max:30|unique:users',
			'password' => 'required|min:8|confirmed'
		];

		return $rules;
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'email.required' => 'forms.createBook.email_required',
			'email.email' => 'forms.createBook.email_email',
			'email.max' => 'forms.createBook.email_max',
			'email.unique' => 'forms.createBook.email_unique',
			'name.required' => 'forms.createBook.author_name_required',
			'name.max' => 'forms.createBook.author_name_max',
			'name.unique' => 'forms.createBook.author_name_unique',
			'password.required' => 'forms.registerUser.password_required',
			'password.min' => 'forms.registerUser.password_min',
			'password.confirmed' => 'forms.registerUser.password_confirmed',
		];
	}

	/**
	 * @param $validator
	 */
	public function withValidator($validator)
	{
		if( $validator->fails() )
		{
			session()->flash('showModal', 'registerModal');
		}
		/*$validator->after(function ($validator)
		{
			if ( $this->hasFile('images') )
			{
				foreach ( $this->file('images') as $image )
				{
					if( ! $image->isValid() ) $validator->errors()->add('images', 'forms.createBook.image_valid');
				}
			}
		});*/
	}
}
