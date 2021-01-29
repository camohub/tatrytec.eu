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
			flash()->error('Pred vstupom do adminstrácie sa musíte prihlásiť.');
			session()->flash('showModal', 'loginModal');
			return redirect()->route('articles');
		}
		elseif( !$user->hasRole([Role::ROLE_ADMIN, Role::ROLE_REDACTOR]) )
		{
			flash('Nemáte oprávnenie vstupovať do adminsitrácie.')->error()->important();
			return redirect()->route('articles');
		}

		return $next($request);
	}
}
