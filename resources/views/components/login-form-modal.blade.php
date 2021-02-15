<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form action="{{route('login')}}" method="post" class="modal-content">
			@csrf
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Prihlásenie</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
					<div class="form-group">
						@if($showModal == 'loginModal')@include('components.form-errors', ['withoutCloseBtn' => TRUE])@endif
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input name="email" type="text" class="form-control" value="{{old('email')}}">
					</div>
					<div class="form-group">
						<label for="password">Heslo</label>
						<input name="password" type="password" class="form-control">
					</div>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn btn-primary" value="Prihlásiť">
				<a href="{{route('forgotten-password-form')}}">Zabudnuté heslo</a>
			</div>
		</form>
	</div>
</div>