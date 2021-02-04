@extends('layout-admin')

@section('content')
	<div class="bgC5">
		<div class="pV30 pH10" id="adminEditMenu">

			<a class="editMenu btn btn-sm btn-primary" href="{{route('admin.categories.sort')}}">Uložiť zmeny</a>
			<span onclick="activateCreateForm(this);" class="btn btn-sm btn-success" title="Create new category">Pridať kategóriu</span>

			@include('admin.categories.components.sortable-categories')

			<a class="editMenu btn btn-sm btn-primary" href="{{route('admin.categories.sort')}}">Uložiť zmeny</a>

		</div>


		<div class="pH10">
			<div id="createSection" class="w200 fL mR20 dN p10 bgC5 bS1">
				<span class="fa fa-lg fa-minus-circle fR" onclick="$('#createSection').slideUp();"
					  title="Hide panel"> </span>

				<h3 class="editItem mV10 pV5 fWB">Vytvoriť sekciu</h3>
				<div class="c3">
					<form action="{{route('admin.categories.create')}}">
						<div class="form-group">
							<label for="name"></label>
							<input name="name" id="name" type="text" class="form-control">
						</div>
						<div class="form-group">
							<label for="parentId"></label>
							<select name="parent_id" id="parentId" class="form-control">
								<option value=""></option>
							</select>
						</div>
						<div class="form-group">
							<input type="submit" name="sbmt" id="" value="Odoslať">
						</div>
					</form>
				</div>
			</div>

			<div id="editSection" class="w200 fL dN p10 bgC5 bS1">
				<span class="fa fa-lg fa-minus-circle fR" onclick="$('#editSection').slideUp();" title="Hide panel"> </span>

				<h3 class="editItem mV10 pV5 fWB">Premenovať</h3>
				<div class="c3">
					{form editSectionForm}
					{input title}
					{input id}
					<br><br>
					{input sbmt}
					{/form}
				</div>
			</div>
		</div>

		<div class="clear pB30"></div>
	</div>

@endsection