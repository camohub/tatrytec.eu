
@if ($errors->any())
    <div class="alert alert-danger alert-important">
		@foreach($errors->all() as $error)
			<div>
				<button type="button" class="close {{isset($withoutCloseBtn) ? 'd-none' : ''}}" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{{ $error }}
			</div>
		@endforeach
    </div>
@endif