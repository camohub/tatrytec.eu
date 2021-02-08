@extends('layout-admin')

@section('content')

<div class="table-responsive" id="adminEditUsers">
	<table class="table table-hover table-striped table-bordered">
		<tr>
			<th>ID</th>
			<th>Meno</th>
			<th>Registovaný</th>
			<th class="text-right">Action</th>
		</tr>
		@forelse($users as $user)
			<tr class="{{$user->deleted_at ? 'bg-warning text-light' : ''}}">
				<td>{{$user->id}}</td>
				<td>{{$user->name}}</td>
				<td>{{$user->created_at->format('j. F Y')}}</td>
				<td class="text-right">
					<a href="{{route('admin.users.edit', ['id' => $user->id])}}" class="user fa fa-pencil fa-lg" title="Edit"
						data-toggle="modal" data-target="#editUserFormModal"
						data-roles="{{$user->roles->implode('id', ',')}}" data-id="{{$user->id}}" data-name="{{$user->name}}" data-email="{{$user->email}}">
					</a>

					<a href="{{route('admin.users.email', ['id' => $user->id])}}" class="user fa fa-envelope fa-lg" title="Confirmation email"></a>

					<a href="{{route('admin.users.block', ['id' => $user->id])}}" class="user fa fa-lg {{$user->deleted_at ? 'fa-minus-circle' : 'fa-check-circle'}}" title="Block/Unblock"></a>
				</td>
			</tr>
		@empty
			<tr>
				<td colspan="4">Nenašli sa žiadny uživatelia.</td>
			</tr>
		@endforelse
	</table>
</div>

<div class="mt-4">
	{{$users->render()}}
</div>


@include('admin.users.components.edit-user-form-modal')


@endsection