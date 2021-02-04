$(function() {
	// .comment is required cause it will catch also articles icons
	let deleteLink = $('.comment.fa-check-circle, .comment.fa-minus-circle');

	//////////////////////////////////////////////////////////////
	/// Event handlers //////////////////////////////////////////
	////////////////////////////////////////////////////////////
	deleteLink.on('click', function( e )
	{
		e.preventDefault();
		deleteComment( $(this) );
	});

	/////////////////////////////////////////////////////////////
	/// Actions ////////////////////////////////////////////////
	///////////////////////////////////////////////////////////
	function deleteComment( target )
	{
		let url = target.attr('href');

		sendPostRequest(url)
			.then(function( response ) {
				let data = response.data;
				if( data.success ) target.toggleClass('fa-check-circle').toggleClass('fa-minus-circle');
				data.error ? showAlert(data.error, 'error') : showAlert(data.success);
			})
			.catch(function( error ) {
				showAlert(error, 'error');
			});
	}
});