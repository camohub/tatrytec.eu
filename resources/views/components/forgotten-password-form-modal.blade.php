<!-- Modal -->
<div class="modal fade" id="forgottenPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgottenPasswordModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form action="{{route('forgotten-password-email')}}" method="post" class="modal-content">
			@csrf
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Zabudnuté heslo</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					@if($showModal == 'forgottenPasswordModal')@include('components.form-errors', ['withoutCloseBtn' => TRUE])@endif
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input name="email" type="text" class="form-control" value="{{old('email')}}">
				</div>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn btn-primary" value="Obnoviť heslo">
			</div>
		</form>
	</div>
</div>