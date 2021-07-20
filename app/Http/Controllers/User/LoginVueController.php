<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use App\Models\Entities\Article;
use App\Models\Entities\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User as SocialUser;
use Laravel\Socialite\Facades\Socialite;
use App\Exceptions\DuplicateUserEmailException;


class LoginVueController extends BaseController
{
	const DRIVER = 'vue';


	public function authenticate(Request $request)
	{
		$email = $request->get('email');
		$password = $request->get('password');

		//if (Auth::attempt($credentials))
		if (Auth::attempt(['email' => $email, 'password' => $password, 'register_token' => NULL]))
		{
			$request->session()->regenerate();

			$user = User::where('email', $email)->where('register_token', NULL)->first();

			if ( !$user->can('create', Article::class) )
			{
				return response([
					'errors' => ['Nemáte oprávnenie vstupovať do administrácie.'],
				]);
			}

			return response()->json(['user' => new UserResource($user)]);
		}
		else if (User::where('email', $email)->whereNotNull('register_token')->first())
		{
			return response([
				'errors' => ['Váš email ešte nebol overený. Skontrolujte si prosím doručenú poštu.'],
			]);
		}

		return response([
			'errors' => ['Nesprávny email alebo heslo.'],
		]);
	}
}
