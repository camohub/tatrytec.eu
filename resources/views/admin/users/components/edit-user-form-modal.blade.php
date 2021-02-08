<!-- Modal -->
<div class="modal fade" id="editUserFormModal" tabindex="-1" role="dialog" aria-labelledby="editUserFormModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form action="{{route('admin.users.edit')}}" id="editUserForm" method="post" class="modal-content">
			@csrf
			<input type="hidden" name="id" id="id" value="">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Upraviť uživateľa</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					@if($showModal == 'editUserFormModal')@include('components.form-errors')@endif
				</div>
				<div class="form-group">
					<label for="name">Meno</label>
					<input name="name" id="name" type="text" class="form-control" value="{{old('name')}}">
				</div>
				<div class="form-group">
					<label for="name">Eamil</label>
					<input name="email" id="email" type="text" class="form-control" value="{{old('email')}}">
				</div>
				<div class="form-group">
					<label for="roles">Rola</label>
					<select name="roles[]" id="roles" class="form-control" multiple>
						@foreach(\App\Models\Entities\Role::all() as $role)
							<option id="role-{{$role->id}}" value="{{$role->id}}">{{$role->name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn btn-primary" value="Uložiť">
			</div>
		</form>
	</div>
</div>