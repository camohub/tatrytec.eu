$(function() {

	let trashLink = $('.fa-trash-o');
	let visibilityLink = $('.js-visibility');

	//////////////////////////////////////////////////////////////
	/// Event handlers //////////////////////////////////////////
	////////////////////////////////////////////////////////////
	trashLink.on('click', function( e )
	{
		e.preventDefault();
		deleteArticle( $(this) );
	});


	visibilityLink.on('click', function( e )
	{
		e.preventDefault();
		changeVisibility( $(this) );
	});

	/////////////////////////////////////////////////////////////
	/// Actions ////////////////////////////////////////////////
	///////////////////////////////////////////////////////////
	function changeVisibility( target )
	{
		let url = target.attr('href');

		sendPostRequest(url)
			.then(function( response ) {
				let data = response.data;
				if( data.success ) target.toggleClass('fa-check-circle').toggleClass('fa-minus-circle');
				showAlert(data);
			})
			.catch(function( error ) {
				showAlert({'error': error});
			})
	}


	function deleteArticle( target )
	{
		let title = target.closest('tr').find('td:first').text();
		let url = target.attr('href');
		if( ! confirm( 'Naozaj chcete zmazať článok: ' + title + '?' ) ) return;

		sendPostRequest(url)
			.then(function( response ) {
				let data = response.data;
				if( data.success ) target.toggleClass('fa-check-circle').toggleClass('fa-minus-circle');
				showAlert(data);
				target.closest('tr').hide();
			})
			.catch(function( error ) {
				showAlert({'error': error});
			});
	}
});