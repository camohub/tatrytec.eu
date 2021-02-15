@extends('email-base')

@section('body')

<h2>Tatrytec.eu</h2>

<div>
	<b>
		Vo vašom mene bolo požiadané o zmenu hesla. Ak ste to neboli vy, ignorujte tento email.<br>
		Ak ste to boli vy kliknite na odkaz.
	</b>
	<a href="{{route('forgotten-password-change', ['token' => $token])}}">Zmeniť heslo"</a>
</div>

@endsection
