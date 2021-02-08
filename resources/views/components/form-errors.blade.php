
@if ($errors->any())
    <div class="alert alert-danger alert-important">
		<button type="button" class="close {{isset($withoutCloseBtn) ? 'd-none' : ''}}" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		@foreach($errors->all() as $error)
			<div>
				{{ $error }}
			</div>
		@endforeach
    </div>
@endif