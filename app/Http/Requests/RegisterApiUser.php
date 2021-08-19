<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class RegisterApiUser extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'name' => 'required|max:30|unique:users',
			'email' => 'required|email|unique:users|max:30',
			'password' => 'required|min:8|confirmed',
		];

		if( $this->get('id') )
		{
			$rules['name'] = 'required|max:30';
			$rules['email'] = 'required|max:30';
			$rules['password'] = 'min:8|confirmed';
		}

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
}
