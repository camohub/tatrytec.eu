<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\BaseController;
use App\Http\Requests\ForgottenPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class ForgottenPasswordController extends BaseController
{

	const SESS_TOKEN_KEY = self::class . '_TOKEN';

	const SESS_EMAIL_KEY = self::class . '_EMAIL';


	public function showForm()
	{
		return back()->with('showModal', 'forgottenPasswordModal');
	}


	public function sendEmail(ForgottenPassword $request)
	{
		$email = $request->get('email');
		$token = sha1(time().rand(0, 100000).time());

		session(self::SESS_TOKEN_KEY, $token);
		session(self::SESS_EMAIL_KEY, $email);

		Mail::mailer('smtp')->to($email)->send(new \App\Mail\ForgottenPassword($token));

		flash()->success('Na vašu emailovú adresu bol odoslaný email cez ktorý sa budete môcť prihlásiť.')->important();
		return back();
	}


	public function changePassword(Request $request)
	{
		$token = $request->get('token');

		if( $token != session(self::SESS_TOKEN_KEY) ) abort(404);

		$user = User::where('email', self::SESS_EMAIL_KEY)->firstOrFail();

		session()->forget([self::SESS_TOKEN_KEY, self::SESS_EMAIL_KEY]);

		Auth::login($user);

		flash()->success('Zmeňte si prosím heslo.')->important();
		session()->flash('showModal', 'changePasswordModal');
		return redirect()->route('user');
	}
}
