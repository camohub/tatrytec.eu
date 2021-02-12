<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Mail\RegisterEmailConfirmation;
use App\Models\User;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class UserController extends BaseController
{


	public function index()
	{
		return view('admin.users.index', [
			'users' => User::withTrashed()
				->orderBy('name', 'ASC')
				->paginate(30)
				->onEachSide(1)
		]);
	}


	public function block( $id )
	{
		if(!Auth::user()->hasRole('admin'))
		{
			flash()->error('Nemáte oprávnenie upravovať uživateľov.')->important();
			return back();
		}

		$user = User::withTrashed()->where('id', $id)->first();

		$user->deleted_at = $user->deleted_at ? NULL : new DateTimeImmutable();
		$user->save();

		return response()->json(['success' => 'Uživateľ bol ' . ($user->deleted_at ? 'zablokovaný.' : 'odblokovaný.')]);
	}




	public function edit(Request $request)
	{
		$user = User::withTrashed()->where('id', $request->get('id') )->first();

		if ( !$user ) return response()->json(['error', 'Uživateľa sa nepodarilo nájsť.']);

		if ( !Auth::user()->hasRole('admin') )
		{
			flash()->error('Nemáte oprávnenie upravovať uživateľov.')->important();
			return back();
		}

		$user->name = $request->get('name', $user->name);
		$user->email = $request->get('email', $user->email);

		$user->roles()->sync($request->get('roles'));
		$user->save();

		flash()->success('Údaje boli uložené do dataázy.');
		return back();
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
