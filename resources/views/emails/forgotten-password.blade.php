@extends('email-base')

@section('body')

<h2>Tatrytec.eu</h2>

<form action="{{route('forgotten-password-set')}}" method="post">
	@csrf
	<input type="hidden" name="token" value="{{$token}}">
	<b>
		Vo vašom mene bolo požiadané o zmenu hesla. Ak ste to neboli vy, ignorujte tento email.<br>
		Ak ste to boli vy kliknite na odkaz.
	</b>
	<input type="submit" value="Zmeniť heslo">
</form>

@endsection
