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
			// The intended method provided by Laravel's redirector will redirect the user to the URL they were attempting to access
			// before being intercepted by the authentication middleware.
			// A fallback URI may be given to this method in case the intended destination is not available.
			return redirect()->intended('/');
		}
		else if (User::where('email', $email)->whereNotNull('register_token')->first())
		{
			return back()->with('showModal', 'loginModal')->withErrors([
				'email' => 'Váš email nieje overený. Skontrolujte prosím doručenú poštu.',
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
