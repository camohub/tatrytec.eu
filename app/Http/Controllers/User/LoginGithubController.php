<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\BaseController;
use App\Models\Entities\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User as SocialUser;
use Laravel\Socialite\Facades\Socialite;
use App\Exceptions\DuplicateUserEmailException;


class LoginGithubController extends BaseController
{
	const DRIVER = 'github';


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
		$githubUser = Socialite::driver(self::DRIVER)->user();

		$user = User::where(['email' => $githubUser->getEmail()])->first();

		try
		{
			$user = $user ?: $this->createUser($githubUser);
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
	 * @param SocialUser $githubUser
	 * @throws DuplicateUserEmailException
	 * @return User
	 */
	private function createUser( SocialUser $githubUser, $i = 1 )
	{
		$name = $githubUser->getName() . ($i === 1 ? '' : $i);

		if( $user = User::where('email', $githubUser->getEmail())->first() ) throw new DuplicateUserEmailException($user);

		if( User::where('name', $name)->first() )
		{
			if( ++$i <= 10 ) $user = $this->createUser($githubUser, $i);
		}
		else
		{
			$user = new User();
			$user->name = $name;
			$user->email = $githubUser->getEmail();
			$user->password = 'no password';
			$user->resource = self::DRIVER;
			$user->save();

			$user->roles()->attach(Role::where('name', Role::ROLE_REGISTERED)->first());
			$user->save();
		}

		return $user;
	}
}
