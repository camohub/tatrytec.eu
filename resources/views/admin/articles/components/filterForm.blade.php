@php
	use App\Models\Services\ArticlesFilterService;
	use App\Models\User;

	$users = User::withTrashed()->orderBy('name')->get();
	$filter = session(ArticlesFilterService::SESS_FILTER);

@endphp

<form action="{{route('admin.articles')}}" method="post" class="mT20">
	<div class="form-row mb-3">
		<div class="col-12 col-md-6">
			<label for="authors">Autori</label>
			<select name="users[]" id="authors" class="form-control" multiple>
				@foreach($users as $user)
					<option value="{{$user->id}}" @if(in_array($user->id, $filter->users)) selected @endif>{{$user->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-12 col-md-6">
			<label for="order">Zoradiť podľa</label>
			<select name="sort[]" id="order"class="form-control" multiple>
				<option value="title DESC" @if(in_array('title DESC', $filter->sort)) selected @endif>Názov zostupne</option>
				<option value="title ASC" @if(in_array('title ASC', $filter->sort)) selected @endif>Názov vzostupne</option>
				<option value="user.name DESC" @if(in_array('user.name DESC', $filter->sort)) selected @endif>Meno zostupne</option>
				<option value="user.name ASC" @if(in_array('user.name ASC', $filter->sort)) selected @endif>Meno vzostupne</option>
				<option value="created_at DESC" @if(in_array('created_at DESC', $filter->sort)) selected @endif>Dátum zostupne</option>
				<option value="created_at ASC" @if(in_array('created_at ASC', $filter->sort)) selected @endif>Dátum vzostupne</option>
			</select>
		</div>
	</div>

	<div class="form-inline mb-3">
		<label for="interval">Interval posledných x dní</label>
		<input type="text" name="interval" id="interval" value="{{$filter->interval ?: ''}}" class="form-control ml-3 mr-3" style="width: 80px;">
	</div>

	<div class="form-inline mb-3">
		<div class="form-check mr-sm-2">
			<input name="remember" @if($filter->remember) checked @endif class="form-check-input" type="checkbox" id="remember">
			<label class="form-check-label" for="remember">Zapamätať si nastavenia</label>
		</div>
	</div>

	<div class="form-row">
		<div class="col-12 col-md-6">
			<input type="submit" name="sbmt" value="Filtrovať" class="btn btn-primary">
		</div>
	</div>

</form>