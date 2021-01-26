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
		{{-- Because of floaded images --}}
		<div class="fb-like" data-colorscheme="dark" data-share="true" data-show-faces="true" data-width="450"></div>
		@if($article->user && Auth::user() && Auth::user()->id == $article->user->id)
			<a href="{{route('admin.articles.edit', ['id' => $article->id])}}" class="small1 fR">editovať</a>
		@endif


		<div class="hr"></div><a name="commentsAnch"></a>

		{{----------------------------------------------------------}}
		{{---------- comments --------------------------------------}}
		{{----------------------------------------------------------}}

		@if(Auth::check())
			<form action="{{route('add-comment')}}">
				@csrf
				<span class="c3">
					<label for="content"></label>
					<i id="showCommentHelp" class="fa fa-lg fa-question-circle"></i>
				</span>

				@include('components.form-errors')

				<div id="commentHelp" class="pA dN bgC9 bS1 p5">**<b>Tučný text</b>**<br>```Kód programu```</div>
				<div class="dN"> Name is a trap to the robots
					<label for="name"></label>
					<input name="name" type="text" class="form-control">
				</div>
				<div class="required">
					<textarea name="content" class="w100P h60"></textarea>
				</div>
				<input type="submit" name="send" class="btn btn-primary">
			</form>
		@else
			<span>Ak chcete pridávať komentáre musíte sa prihlásiť <a data-toggle="modal" data-target="#loginModal" class="pointer">prihlásiť na webe</a>, alebo cez sieť</span> &nbsp;&nbsp;

			<a href="{{route('github.login')}}" id="githubLogin">
				<img src="/imgs/github.svg" alt="Github octocat" />
				Github login
			</a>
			<a href="{{route('google.login')}}" id="gLogin">
				<img src="/imgs/google.svg" alt="Google logo" />
				Google login
			</a>
			<a href="{{route('facebook.login')}}" id="fbLogin">
				<img src="/imgs/facebook.svg" alt="Facebook logo" />
				Facebook login
			</a>
		@endif

		<div class="pV30" id="comments">
			@foreach($comments as $comment)
				<div class="p10 bR5 {{$loop->iterator % 2 ? 'bgC5' : ''}}">
					<div class="small1 c3 fWB">
						<span class="commUserName cP">{{$comment->user->user_name}}</span>&nbsp;&nbsp;&nbsp; {{$comment->created_at->format('j. F Y')}}
					</div>
					<div class="pB10 pT5">
						@if($comment->deleted_at)
							<i class="c3">Komentár bol zmazaný.</i>
						@else
							{!!$comment->content!!}
						@endif
					</div>
				</div>
			@endforeach
		</div>

		<script>
			$('.commUserName').on('click', function()
			{
				var area = $('#frm-commentForm-content');
				area.val(area.val() + '**' + $(this).text() + '** ').focus();
			});

			$( '#showCommentHelp' )
				.on( 'mouseenter', function() { $( '#commentHelp' ).css( 'display', 'block' ); } )
				.on( 'mouseleave', function() { $( '#commentHelp' ).css( 'display', 'none' ); } );
		</script>

	@endif

@endsection