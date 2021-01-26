<?php

namespace App\Http\Controllers;


use App\Models\Entities\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User as SocialUser;
use Laravel\Socialite\Facades\Socialite;
use App\Exceptions\DuplicateUserEmailException;


class LoginFacebookController extends BaseController
{
	const DRIVER = 'facebook';


	public function authenticate()
	{
		$this->setReffer();
		//return redirect('https://github.com/login/oauth/authorize');
		return Socialite::driver(self::DRIVER)
			//->scopes(['user:follow'])
			->redirect();
	}


	public function callback()
	{
		$googleUser = Socialite::driver(self::DRIVER)->user();

		$user = User::where(['email' => $googleUser->getEmail(), 'resource' => self::DRIVER])->first();

		try
		{
			$user = $user ?: $this->createUser($googleUser);
		}
		catch( DuplicateUserEmailException $e )
		{
			flash('Používateľ so zadaným emailom je už zaregistrovaný cez ' . ($e->user->resource ?: ' web registráciu.'))->error()->important();
			return redirect()->to($this->getRefferer());
		}

		$this->loginUser($user);

		return redirect()->to($this->getRefferer());
	}


	public function loginUser(User $user)
	{
		Auth::login($user);
		flash('Vitajte na palube ' . $user->name . '.')->success();
	}


	/**
	 * @param SocialUser $googleUser
	 * @throws DuplicateUserEmailException
	 * @return User
	 */
	private function createUser( SocialUser $googleUser, $i = 1 )
	{
		$name = $googleUser->getName() . ($i === 1 ? '' : $i);

		if( $user = User::where('email', $googleUser->getEmail())->first() ) throw new DuplicateUserEmailException($user);

		if( User::where('name', $name)->first() )
		{
			if( ++$i <= 10 ) $user = $this->createUser($googleUser, $i);
		}
		else
		{
			$user = new User();
			$user->name = $name;
			$user->email = $googleUser->getEmail();
			$user->password = 'no password';
			$user->resource = self::DRIVER;
			$user->social_network_params = json_encode($googleUser);
			$user->save();

			$user->roles()->attach(Role::where('name', Role::ROLE_REGISTERED)->first());
			$user->save();
		}

		return $user;
	}
}
