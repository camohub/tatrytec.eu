<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends BaseController
{
	/**
	 * Handle an authentication attempt.
	 */
	public function authenticate(Request $request)
	{
		$email = $request->get('email');;
		$password = $request->get('password');

		//if (Auth::attempt($credentials))
		if (Auth::attempt(['email' => $email, 'password' => $password, 'register_token' => NULL]))
		{
			$request->session()->regenerate();
			flash('Vitajte na palube '. Auth::user()->name .'.')->success();
			return back();
		}
		else if (User::where('email', $email)->whereNotNull('register_token')->first())
		{
			return back()->with('showModal', 'loginModal')->withErrors([
				'email' => 'Váš email ešte nebol overený. Skontrolujte si prosím doručenú poštu.',
			]);
		}

		return back()->with('showModal', 'loginModal')->withErrors([
			'email' => 'Nesprávny email alebo heslo.',
		]);
	}

	/**
	 * Log the user out of the application.
	 */
	public function logout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();

		flash('Boli ste odhlásený.')->success();
		return redirect('/');
	}
}
