@extends('email-base')

@section('body')

<h2>Vitajte na portáli Tatrytec.eu</h2>

<div>
	<b>
		Pre dokončenie regitrácie je potrebné overenie vašej emailovej adresy.
		<a href="{{route('register.confirm-email', ['id' => $user->id, 'token' => $user->register_token])}}">Kliknite prosím na odkaz</a>
	</b>
</div>
