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
			'email.required' => 'Vyplňte prosím email.',
			'email.email' => 'Email nemá platný formát.',
			'email.max' => 'Povolená dĺžka emailu je 30 znakov.',
			'email.unique' => 'Zadaná emailová adresa je už zaregistrovaná.',
			'name.required' => 'Vyplňte prosím meno.',
			'name.max' => 'Povolená dĺžka mena je 30 znakov.',
			'name.unique' => 'Vybrané meno je už zaregistrované.',
			'password.required' => 'Vyplňte prosím heslo.',
			'password.min' => 'Minimálna dĺžka hesla je 8 znakov.',
			'password.confirmed' => 'Heslá sa nezhodujú.',
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
