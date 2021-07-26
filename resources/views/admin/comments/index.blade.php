@extends('layout-admin')


@section('content')

	<h1><a href="{{route('admin.articles')}}">{{$article->title}}</a></h1>

	<span class="fS09 fWB">autor: {{$article->user->name ?? 'neznámy'}}</span>

	<h3 class="fS12 mV20">Komentáre k článku</h3>

	@forelse($comments as $comment)
		<div class="p10 {{$loop->odd ? 'bgC7' : ''}}">
			<a href="{{route('admin.comments.delete', ['article_id' => $article->id, 'comment_id' => $comment->id])}}"
				class="fa fa-lg float-right comment {{$comment->deleted_at ? 'fa-minus-circle' : 'fa-check-circle'}}"
				title="Delete/Undelete"> </a>

			<div class="fS09 c1"><b>{{$comment->user->name}}</b> {{$comment->created_at->format('j.n.Y H:i')}}</div>
			<div class="pV5">{!! $comment->text !!}</div>
		</div>
		@if($loop->last)
			<div>
				{{$comments->render()}}
			</div>
		@endif
	@empty
		<div class="p10">Nenašli sa žiadne komentáre</div>
	@endforelse

@endsection