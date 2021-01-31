@php
	use App\Models\Services\ArticlesFilterService;
	use App\Models\User;

	$users = User::withTrashed()->orderBy('name')->get();
	$filter = session(ArticlesFilterService::SESS_FILTER);

@endphp

<form action="{{route('admin.articles')}}" method="post" class="mT20">
	@csrf
	<div class="form-row mb-3">
		<div class="col-12 col-md-6">
			<label for="authors">Autori</label>
			<select name="users[]" id="authors" class="form-control" multiple size="5">
				@foreach($users as $user)
					<option value="{{$user->id}}" @if(in_array($user->id, $filter->users)) selected @endif>{{$user->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-12 col-md-6">
			<label for="order">Zoradiť podľa</label>
			<select name="sort" id="order"class="form-control" size="5">
				<option value="title DESC" @if('title DESC' == $filter->sort) selected @endif>Názov zostupne</option>
				<option value="title ASC" @if('title ASC' == $filter->sort) selected @endif>Názov vzostupne</option>
				<option value="user.name DESC" @if('user.name DESC' == $filter->sort) selected @endif>Meno zostupne</option>
				<option value="user.name ASC" @if('user.name ASC' == $filter->sort) selected @endif>Meno vzostupne</option>
				<option value="created_at DESC" @if('created_at DESC' == $filter->sort) selected @endif>Dátum zostupne</option>
				<option value="created_at ASC" @if('created_at ASC' == $filter->sort) selected @endif>Dátum vzostupne</option>
			</select>
		</div>
	</div>

	<div class="form-inline mb-3">
		<div class="form-group">
			<label for="title">Názov</label>
			<input type="text" name="title" id="title" value="{{$filter->title ?: ''}}" class="form-control ml-3 mr-3">
		</div>
		<div class="form-group">
			<label for="interval">Interval posledných x dní</label>
			<input type="text" name="interval" id="interval" value="{{$filter->interval ?: ''}}" class="form-control ml-3 mr-3" style="width: 80px;">
		</div>
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