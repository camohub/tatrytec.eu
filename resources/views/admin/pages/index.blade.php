@extends('layout-admin')


@section('content')

<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover">
		<tr>
			<th>Názov</th>
			<th style="min-width: 170px;" class="text-right">Akcia <a href="{{route('admin.pages.create')}}" class="fa fa-lg fa-plus c7" title="Create new"> </a></th>
		</tr>
		@forelse($pages as $page)
			<tr>
				<td>{{$page->title}}</td>
				<td class="text-right">
					@if(Auth::user()->hasRole('admin'))
						<a href="{{route('admin.pages.edit', ['id' => $page->id])}}" class="fa fa-lg fa-pencil" title="Edit"></a>
						<a href="{{route('admin.pages.visibility', ['id' => $page->id])}}" class="fa fa-lg page js-visibility {{$page->visible ? 'fa-check-circle' : 'fa-minus-circle'}}" title="Visible/Hidden"></a>
						<a href="{{route('admin.pages.delete', ['id' => $page->id])}}" class="fa fa-lg page fa-trash-o" title="Delete"></a>
					@endif
				</td>
			</tr>
		@empty
			<tr>
				<td colspan="2">Neboli nájdené žiadne stránky</td>
			</tr>
		@endforelse
	</table>
</div>

@endsection