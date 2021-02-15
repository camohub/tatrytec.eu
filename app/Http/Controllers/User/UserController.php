<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\BaseController;
use App\Http\Requests\ChangePassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends BaseController
{

	public function index()
	{
		return view('user.index', ['user' => Auth::user()]);
	}


	public function changePassword(ChangePassword $request)
	{
		$user = Auth::user();

		$user->password = Hash::make($request->get('password'));
		$user->save();

		flash()->success('Heslo bolo zmenené.')->important();
		return redirect()->route('user');
	}
}
