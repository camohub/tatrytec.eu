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

		if( !$user || (!$user->isInRole(Role::ROLE_ADMIN) && !$user->isInRole(Role::ROLE_REDACTOR)) )
		{
			flash('Nemáte oprávnenie vstupovať do adminsitrácie.')->error()->important();
			return redirect()->route('articles');
		}

		return $next($request);
	}
}
