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

			Mail::mailer('mailgun')->to($user)->send(new RegisterEmailConfirmation($user));
		}
		catch ( \Exception $e )
		{
			Log::error($e);
			return response()->json(['error' => 'Pri odosielaní emailu došlo k chybe.']);
		}

		return response()->json(['success' => 'Bol odoslaný konfirmačný email.']);
	}


//////component/////////////////////////////////////////////////////////////////////////////


	protected function createComponentEditForm()
	{
		$form = new Nette\Application\UI\Form;
		$id = (int) $this->getParameter( 'id' );

		$form->addProtection( 'Vypršal čas vyhradený pre odoslanie formulára. Z dôvodu rizika útoku CSRF bola požiadavka na server zamietnutá.', 'error' );

		$rolesSel = $this->usersModel->rolesToSelect();
		$rolesDefaults = $this->usersModel->setRolesDefaults( $id );
		$form->addMultiSelect( 'roles', 'Uživatľské role', $rolesSel, '5' )
			->setRequired( 'Musíte vybrať jedného uživateľa.' )
			->setDefaultValue( $rolesDefaults )
			->setAttribute( 'class', 'w150 b7' );

		$form->addCheckbox( 'confirmEmail', ' Overiť emailovú adresu.' );

		$form->addSubmit( 'send', 'Uložiť' )
			->setAttribute( 'class', 'formElB' );

		$form->onSuccess[] = $this->editFormSucceeded;
		return $form;
	}


	/**
	 * @param $form
	 */
	public function editFormSucceeded( $form )
	{
		$values = $form->getValues();
		$id = (int) $this->getParameter( 'id' );

		try
		{
			$this->usersModel->setUserRoles( $id, $values->roles );
		}
		catch ( \Exception $e )
		{
			$this->flashMessage( 'Pri nastavovaní užívateľských rolí došlo k chybe. Skontrolujte prosím aké práva má užívateľ nastavené.', 'error' );
			return;
		}

		if ( $values->confirmEmail )
		{
			$this->em->beginTransaction();

			try
			{
				$template = $this->createTemplate()->setFile( __DIR__ . '/../templates/Users/email.latte' );
				$this->usersModel->sendConfirmEmail( $template, $id );
			}
			catch ( \Exception $e )
			{
				$this->em->rollback();
				$this->flashMessage( 'Pri odosielaní emailu došlo k chybe. Email pravdepodobne nebol odoslaný.', 'error' );
				return;
			}

			$this->em->commit();
			$this->flashMessage( 'Bol odoslaný konfirmačný email.' );

		}

		$this->flashMessage( 'Nastavenia boli zmenené.' );
		$this->redirect( 'this' );

	}

}
