<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\BaseController;
use App\Mail\RegisterEmailConfirmation;
use App\Models\User;
use App\Http\Requests\RegisterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class RegisterController extends BaseController
{
	/**
	 * Handle an authentication attempt.
	 */
	public function register(RegisterUser $request)
	{
		$name = $request->get('name');
		$email = $request->get('email');
		$password = $request->get('password');

		$user = new User();
		$user->email = $email;
		$user->name = $name;
		$user->password = Hash::make($password);
		$user->register_token = sha1($password . time() . $name);
		$user->save();

		Mail::mailer('smtp')->to($user)->send(new RegisterEmailConfirmation($user));

		flash('Vitajte na palube '. $user->name .'. Skontrolujte si prosím mailovú schránku a potvrďte svoju emailovú adresu.')->success()->important();

		return back();
	}


	public function confirmEmail(Request $request, $id, $token)
	{
		$user = User::where('id', $id)->where('register_token', $token)->first();

		if (!$user) abort(404);

		$user->register_token = NULL;
		$user->save();

		Auth::login($user);

		$request->session()->regenerate();
		flash('Vitajte na palube '. Auth::user()->name .'. Váš email bol overený a váš účet je aktivovaný.')->success();
		// The intended method provided by Laravel's redirector will redirect the user to the URL they were attempting to access
		// before being intercepted by the authentication middleware.
		// A fallback URI may be given to this method in case the intended destination is not available.
		return redirect()->route('articles');
	}
}
