<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as AuthenticateMiddleware;

class Authenticate extends AuthenticateMiddleware
{
	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return string|null
	 */
	protected function redirectTo($request)
	{
		if (! $request->expectsJson()) {
			session()->flash('showModal', 'loginModal');
			return route('articles');
		}
	}
}
