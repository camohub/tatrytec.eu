<?php

namespace App\Http\Middleware;

use App\Models\Entities\Role;
use Closure;
use Illuminate\Http\Request;

class Admin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		$user = $request->user();

		if( !$user )
		{
			session()->flash('showModal', 'loginModal');
			return redirect()->route('articles', ['slug' => 'najnovsie'])->withErrors(['login' => 'You have to log in to access admin module.']);
		}
		elseif( !$user->hasRole([Role::ROLE_ADMIN, Role::ROLE_REDACTOR]) )
		{
			flash('Nemáte oprávnenie vstupovať do adminsitrácie.')->error()->important();
			return redirect()->route('articles', ['slug' => 'najnovsie']);
		}

		return $next($request);
	}
}
