
$(function() {

	if( typeof showComments !== 'undefined' && showComments )
	{
		let commentsWrapper = $( '#commnentsWrapper' );
		let commentsPagination = $( '#commentsPaginationWrapper' );
		let addCommentForm = $( '#addCommentForm' );
		let commentFormErrors = $( '#commentFormErrors' );  // Error message block
		let commentFormSuccess = $( '#commentFormSuccess' );  // Success message block
		let commentText = $('#commentText');  // Textarea
		let showCommentHelp = $('#showCommentHelp');  // Nápoveda icona
		let commentHelp = $('#commentHelp'); // Nápoveda

		addCommentForm.submit( function( e )
		{
			e.preventDefault();
			addComment();
		} );

		getCommnents();

		function getCommnents( url )
		{
			url = url || '/show-comments?page=1';

			$.ajax( {
				url: url,
				type: 'POST',
				data: {
					articleId: detailArticleId
				},
				headers: {
					'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
				},
				success: function( response )
				{
					console.log( response );
					var commentsHtml = '';

					$.each( response.comments.data, function( index, item )
					{
						commentsHtml += getCommentTemplate( item );
					} );

					commentsWrapper.empty().append( commentsHtml );
					commentsPagination.find( '.active' ).removeClass( 'active' );
					commentsPagination.html( response.pagination );

					console.log(response.pagination);

					createPaginationHandlers();
				}
			} );
		}

		function addComment()
		{
			if ( addCommentForm.find( '#commentText' ).val().trim() == '' )
			{
				addCommentForm.find( '#commentFormErrors' ).text( 'Vložte prosím text recenzie.' );
				setTimeout( function() { commentFormErrors.text( '' ) }, 3500 );
				return;
			}

			let url = addCommentForm.attr( 'action' );

			$.ajax( {
				url: url,
				type: 'POST',
				data: addCommentForm.serialize(),
				headers: {
					'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
				},
				success: function( response )
				{

					console.log( response );
					addCommentForm.trigger( "reset" );  // clear inputs

					if ( response.success ) commentFormSuccess.text( response.success );
					else if ( response.error ) commentFormErrors.text( response.success );

					setTimeout( function()
					{
						commentFormSuccess.text( '' );
						commentFormErrors.text( '' )
					}, 3500 );
					getCommnents();
				}
			} );
		}


		function createPaginationHandlers()
		{
			let page = parseInt( commentsPagination.find( '.page-item.active span' ).first().text() );

			commentsPagination.find( 'a' ).click( function( e )
			{
				e.preventDefault();

				let li = $( this ).closest( 'li' );
				let link = $( this );

				if ( li.hasClass( "disabled" ) ) return;

				var lastActiveItem = commentsPagination.find( '.page-item.active' );
				lastActiveItem.removeClass( "active" );

				var isRight = link.attr( "rel" ) === "next";
				var isLeft = link.attr( "rel" ) === "prev";

				if ( isRight ) lastActiveItem.next().addClass( "active" );
				else if ( isLeft ) lastActiveItem.prev().addClass( "active" );
				else li.addClass( "active" );

				getCommnents( link.attr( 'href' ) );
			} );
		}


		function getCommentTemplate( item )
		{
			return `
				<div class="comment-item">
					<img src="${item.user?.image?.url ? item.user?.image?.url : '/imgs/empty/empty_square.png'}" alt="" class="comment-img">
					<div class="comment-body">
						<div class="comment-body-top">
							<div class="comment-body-top-texts">
								<b class="comment-author commentUserName">${item.user.name}</b>&nbsp;&nbsp;&nbsp; 
								<small class="comment-date">${item.created}</small>
							</div>
						</div>
						<div class="comment-body-content">
							<p>${item.text}</p>
						</div>
					</div>
				</div>
			`
		}



		// Arrow func. does not handle $(this) as ES5 func.
		commentsWrapper.on('click', '.commentUserName', function() { commentText.val(commentText.val() + '*@' + $(this).text() + '* ').focus() });

		showCommentHelp.on('mouseenter', () => commentHelp.css('display', 'block'))
			.on('mouseleave', () => commentHelp.css('display', 'none'));
	}
});