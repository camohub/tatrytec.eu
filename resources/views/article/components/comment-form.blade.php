{{-- Formulár sa spracovváva ajaxovo takže niektoré veci ako error handling sa robia cez aajax --}}
@if(Auth::check())
	<form action="{{route('add-comment')}}" method="post" id="addCommentForm">
		@csrf
		<input type="hidden" name="article_id" value="{{$article->id}}">
		<div class="comment-form">
			<div class="row">
				<div class="col-12 position-relative">
					<span class="help">
						<label for="commentText">Vložte komentár</label>
						<i id="showCommentHelp" class="fa fa-lg fa-question-circle"></i>
					</span>
					<div id="commentHelp">*<b>Tučný text</b>*<br>```Kód programu```</div>
				</div>
				<div class="col-12">
					<div class="mb-2 text-danger" id="commentFormErrors">
						@if($errors->has('product_id')) {{$errors->first('product_id')}} @endif
						@if($errors->has('text')) {{$errors->first('text')}} @endif
					</div>
					<div class="mb-2 text-success" id="commentFormSuccess"></div>
					<div class="form-group">
						<textarea name="text" id="commentText" class="form-control" id="exampleFormControlTextarea1" rows="5"
								 placeholder="Napíš komentár . . .  "></textarea>
					</div>
				</div>
				<div class="col-12 d-flex justify-content-end">
					<button id="addCommnent" type="submit" class="btn btn-primary px-5 mt-4">Pridať komentár</button>
				</div>
			</div>
		</div>
	</form>
@else
	<span>Ak chcete pridávať komentáre musíte sa prihlásiť <a data-toggle="modal" data-target="#loginModal" class="pointer">prihlásiť na webe</a>, alebo cez sieť</span> &nbsp;&nbsp;

	<a href="{{route('github.login')}}" id="githubLogin"><img src="/imgs/github.svg" alt="Github octocat" />Github login</a>
	<a href="{{route('google.login')}}" id="gLogin"><img src="/imgs/google.svg" alt="Google logo" />Google login</a>
	<a href="{{route('facebook.login')}}" id="fbLogin"><img src="/imgs/facebook.svg" alt="Facebook logo" />Facebook login</a>
@endif
