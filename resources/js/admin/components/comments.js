$(function() {

	let deleteLink = $('.fa-check-circle, .fa-minus-circle');

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
		if( ! confirm( 'Naozaj chcete zmazať tento komentár?' ) ) return;

		sendPostRequest(url)
			.then(function( response ) {
				let data = response.data;
				if( data.success ) target.toggleClass('fa-check-circle').toggleClass('fa-minus-circle');
				showAlert(data.success);
			})
			.catch(function( error ) {
				showAlert(error, 'error');
			});
	}
});