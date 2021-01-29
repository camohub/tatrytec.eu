@extends('layout-full')

@section('content')

	@if(isset($articles)){{-- Show more articles --}}

		@foreach($articles as $a)
			<h1><a href="{{route('articles', ['slug' => $a->slug])}}">{{$a->title}}</a></h1>
			<div class="content">{!!$a->perex!!}</div>
			<div class="small1 pT10 pB20">{{$a->created_at->format('j. F Y')}}<span> / {{$a->user->name}}</span></div>
		@endforeach

		{{$articles->links()}}

	@endif


	@if(isset($article)){{-- Shows one article --}}

		<h1>{{$article->title}}</h1>

		<div class="small1 fWB">
			{{$article->created_at->format('j. F Y')}}@if($article->user)<span> / {{$article->user->userName}}</span>@endif
		</div>

		<div>{!!$article->perex!!}{!!$article->content!!}</div>
		<div class="clear pT10"></div>

		{{-- Because of floated images --}}
		<div class="fb-like" data-colorscheme="dark" data-share="true" data-show-faces="true" data-width="450"></div>
		@if($article->user && Auth::user() && Auth::user()->id == $article->user->id)
			<a href="{{route('admin.articles.edit', ['id' => $article->id])}}" class="small1 fR">editovať</a>
		@endif


		<div class="hr"></div><a name="commentsAnch"></a>

		{{----------------------------------------------------------}}
		{{---------- COMMENTS --------------------------------------}}
		{{----------------------------------------------------------}}

		<div id="commnentsWrapper">
			{{-- FILLED BY AJAX --}}
		</div>

		<script>
			var detailArticleId = {{$article->id}};
			var showComments = true;
		</script>

		<nav id="commentsPaginationWrapper" aria-label="Comments navigation">
			{{--{{$products->appends(request()->query())->render()}}--}}
		</nav>

		@include('article.components.comment-form')

	@endif

@endsection