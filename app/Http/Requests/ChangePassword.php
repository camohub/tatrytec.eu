<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ChangePassword extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
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
			session()->flash('showModal', 'changePasswordModal');
		}
	}
}
