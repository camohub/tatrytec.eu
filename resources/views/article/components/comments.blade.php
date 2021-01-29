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
		var area = $('#content');
		area.val(area.val() + '**' + $(this).text() + '** ').focus();
	});
</script>