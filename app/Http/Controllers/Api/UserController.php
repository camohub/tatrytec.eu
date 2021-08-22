<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Http\Requests\RegisterApiUser;
use App\Http\Resources\UserResource;
use App\Mail\RegisterEmailConfirmation;
use App\Models\Entities\Role;
use App\Models\Services\RolesService;
use App\Models\Services\UsersService;
use App\Models\User;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class UserController extends BaseController
{

	public function index(Request $request)
	{
		if( !$request->user()->hasRole(Role::ROLE_ADMIN) ) return response()->json(['error' => 'Nemáte oprávnenie editovať uživateľov.']);

		$users = User::withTrashed()->orderBy('name', 'ASC')->get();

		return response()->json(['users' => UserResource::collection($users)]);
	}


	public function store(RegisterApiUser $request, $id = NULL)
	{
		if( !$request->user()->hasRole(Role::ROLE_ADMIN) ) return response()->json(['error' => 'Nemáte oprávnenie editovať uživateľov.']);

		$name = $request->get('name');
		$email = $request->get('email');
		$password = $request->get('password');
		$roles = $request->get('roles');

		$user = $id ? User::where('id', $id)->withTrashed()->first() : new User();

		$user->name = $name;
		$user->email = $email;
		if( $password ) $user->password = Hash::make($password);
		if( $id ) $user->register_token = sha1($password . time() . $name);
		$user->save();
		$user->roles()->sync($roles);
		$user->save();

		if( !$id ) Mail::mailer('smtp')->to($user)->send(new RegisterEmailConfirmation($user));

		return response()->json(['id' => $user->id]);
	}


	public function toggleDelete( Request $request, $id )
	{
		if( !$request->user()->hasRole(Role::ROLE_ADMIN) ) return response()->json(['error' => 'Nemáte oprávnenie editovať uživateľov.']);

		$user = User::withTrashed()->where('id', $id)->first();

		$user->deleted_at = $user->deleted_at ? NULL : new DateTimeImmutable();
		$user->save();

		return response()->json(['success' => 'Uživateľ bol ' . ($user->deleted_at ? 'zablokovaný.' : 'odblokovaný.')]);
	}



	public function edit(Request $request, $id)
	{
		$user = User::where('id', $id)->withTrashed()->first();

		if( !$user ) return response()->json(['error' => 'Uživateľ nebol nájdený.']);

		if ( !$request->user()->hasrole(Role::ROLE_ADMIN) ) return response()->json(['error' => 'Nemáte oprávnenie upravovať profil uživateľa.']);

		return response()->json(['user' => new UserResource($user)]);
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


	public function getSelectRoles()
	{
		return response()->json(['selectRoles' => Role::all()]);
	}

}
