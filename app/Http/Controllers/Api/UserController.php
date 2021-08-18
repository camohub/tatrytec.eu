<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use App\Mail\RegisterEmailConfirmation;
use App\Models\Entities\Role;
use App\Models\User;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class UserController extends BaseController
{

	public function index(Request $request)
	{
		if( $request->user()->hasRole(Role::ROLE_ADMIN) ) return response()->json(['error' => 'Nemáte oprávnenie editovať uživateľov.']);

		$users = User::withTrashed()->orderBy('name', 'ASC')->get();

		return response()->json(['users' => UserResource::collection($users)]);
	}


	public function toggleDelete( Request $request, $id )
	{
		if( !$request->user()->hasRole(Role::ROLE_ADMIN) ) return response()->json(['error' => 'Nemáte oprávnenie upravovať uživateľov.']);

		$user = User::withTrashed()->where('id', $id)->first();

		$user->deleted_at = $user->deleted_at ? NULL : new DateTimeImmutable();
		$user->save();

		return response()->json(['success' => 'Uživateľ bol ' . ($user->deleted_at ? 'zablokovaný.' : 'odblokovaný.')]);
	}




	public function edit(Request $request)
	{
		$user = User::withTrashed()->where('id', $request->get('id') )->first();

		if ( !$user ) return response()->json(['error', 'Uživateľa sa nepodarilo nájsť.']);

		if ( !$request->user()->hasRole(Role::ROLE_ADMIN) ) return response()->json(['error' => 'Nemáte oprávnenie upravovať uživateľov.']);

		$user->name = $request->get('name', $user->name);
		$user->email = $request->get('email', $user->email);

		$user->roles()->sync($request->get('roles'));
		$user->save();

		return response()->json(['success' => 'Údaje boli uložené do databázy.']);
	}


	public function email( $id )
	{
		try
		{
			$user = User::withTrashed()->where('id', $id)->first();
			$user->register_token = Hash::make(time() . rand(0, 10000));
			$user->save();

			Mail::mailer('smtp')->to($user)->send(new RegisterEmailConfirmation($user));
		}
		catch ( \Exception $e )
		{
			Log::error($e);
			return response()->json(['error' => 'Pri odosielaní emailu došlo k chybe.']);
		}

		return response()->json(['success' => 'Bol odoslaný konfirmačný email.']);
	}

}
