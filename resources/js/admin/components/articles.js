$(function() {

	let trashLink = $('.article.fa-trash-o');
	let visibilityLink = $('.article.js-visibility');

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
				data.error ? showAlert(data.error, 'danger') : showAlert(data.success);
			})
			.catch(function( error ) {
				showAlert(error, 'danger');
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
				showAlert(data.success);
				target.closest('tr').hide();
			})
			.catch(function( error ) {
				showAlert(error, 'danger');
			});
	}
});