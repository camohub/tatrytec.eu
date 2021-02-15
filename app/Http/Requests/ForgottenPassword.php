<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ForgottenPassword extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'email' => 'required|email|max:30',
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
			'email.required' => 'Vyplňte prosím email.',
			'email.email' => 'Email nemá platný formát.',
			'email.max' => 'Povolená dĺžka emailu je 30 znakov.',
		];
	}

	/**
	 * @param $validator
	 */
	public function withValidator($validator)
	{
		if( $validator->fails() )
		{
			session()->flash('showModal', 'forgottenPasswordModal');
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
