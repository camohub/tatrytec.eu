@extends('layout-admin')

@section('content')
	<div class="bgC5">
		<div class="pV30 pH10" id="adminEditMenu">

			<a class="editSort btn btn-sm btn-primary" href="{{route('admin.categories.sort')}}">Uložiť zmeny</a>
			<button data-toggle="modal" data-target="#editCategoryFormModal" rel="nofollow" class="btn btn-sm btn-success" title="Create new category">Pridať kategóriu</button>

			@include('admin.categories.components.sortable-categories')

			<a class="editSort btn btn-sm btn-primary" href="{{route('admin.categories.sort')}}">Uložiť zmeny</a>

		</div>
	</div>

	@include('admin.categories.components.edit-category-form-modal')

@endsection