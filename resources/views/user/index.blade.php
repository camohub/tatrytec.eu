@extends('layout-full')

@section('content')

	<h1>Váš účet</h1>

	<div>
		Meno: <b>{{$user->name}}</b>
	</div>
	<div>
		Email: <b>{{$user->email}}</b>
	</div>
	<div>
		Zaregistrovaný <b>{{$user->created_at->format('d.m.Y H:i:s')}}</b>
	</div>
	<div>
		<a data-toggle="modal" data-target="#changePasswordModal" rel="nofollow" class="pointer">Zmeniť heslo</a>
	</div>


	<!-- Modal -->
	<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<form action="{{route('user.change-password')}}" method="post" class="modal-content">
				@csrf
				<div class="modal-header">
					<h3 class="modal-title" id="exampleModalLabel">Zmeniť heslo</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						@if($showModal == 'changePasswordModal')@include('components.form-errors', ['withoutCloseBtn' => TRUE])@endif
					</div>
					<div class="form-group">
						<label for="password">Heslo</label>
						<input name="password" type="password" class="form-control">
					</div>
					<div class="form-group">
						<label for="password">Zopakovať heslo</label>
						<input name="password_confirmation" type="password" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="Zmeniť heslo">
				</div>
			</form>
		</div>
	</div>

@endsection