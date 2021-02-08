<!-- Modal -->
<div class="modal fade" id="createCategoryFormModal" tabindex="-1" role="dialog" aria-labelledby="createCategoryFormModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form action="{{route('admin.categories.create')}}" id="createCategoryForm" method="post" class="modal-content">
			@csrf
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Vytvoriť kategóriu</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					@if($showModal == 'createCategoryModal')@include('components.form-errors')@endif
				</div>
				<div class="form-group">
					<label for="name">Názov</label>
					<input name="name" id="name" type="text" class="form-control" value="{{old('name')}}">
				</div>
				<div class="form-group">
					<label for="password">Nadradená kategória</label>
					<select name="parent_id" id="parentId" class="form-control">
						<option value="">Vyberte katagóriu</option>
						@foreach($categoriesToSelect as $id => $name)
							<option value="{{$id}}">{{$name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn btn-primary" value="Odoslať">
			</div>
		</form>
	</div>
</div>