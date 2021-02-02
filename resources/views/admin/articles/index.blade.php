@extends('layout-admin')


@section('content')

<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover">
		<tr>
			<th>Názov</th>
			<th>Autor</th>
			<th>Vytvorené</th>
			<th style="min-width: 170px;" class="text-right">Akcia <a href="{{route('admin.articles.create')}}" class="fa fa-lg fa-plus c7" title="Create new"> </a></th>
		</tr>
		@foreach($articles as $article)
			<tr>
				<td>{{$article->title}}</td>
				<td>{{$article->user ? $article->user->name : ''}}</td>
				<td>{{$article->created_at->format('j.n. Y')}}</td>
				<td class="text-right">
					@if(Auth::user()->can('update', $article))
						<a href="{{route('admin.articles.edit', ['id' => $article->id])}}" class="fa fa-lg fa-pencil" title="Edit"></a>
						<a href="{{route('admin.articles.visibility', ['id' => $article->id])}}" class="fa fa-lg js-visibility {{$article->visible ? 'fa-check-circle' : 'fa-minus-circle'}}" title="Visible/Hidden"></a>
						<a href="{{route('admin.articles.comments', ['id' => $article->id])}}" class="fa fa-lg fa-commenting-o" title="Show comments"></a>
						<a href="{{route('admin.articles.delete', ['id' => $article->id])}}" class="fa fa-lg fa-trash-o" title="Delete"></a>
					@endif
				</td>
			</tr>
		@endforeach
	</table>
</div>

@if(Auth::user()->hasRole('admin'))
	<div class="pV20">
		<h4>Filtrovať podľa</h4>
		@include('admin.articles.components.filterForm')
	</div>
@endif

@endsection