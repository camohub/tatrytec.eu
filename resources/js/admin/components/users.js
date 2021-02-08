$(function() {

	let adminEditUsers = $('#adminEditUsers');
	let editUserForm = $('#editUserForm');

	console.log(adminEditUsers);

	//////////////////////////////////////////////////////////////
	/// Event handlers //////////////////////////////////////////
	////////////////////////////////////////////////////////////
	adminEditUsers.find('.fa-check-circle, .fa-minus-circle').on('click', function( e )
	{
		e.preventDefault();
		blockUnblock($(this));
	});


	adminEditUsers.find('.fa-pencil').on('click', function(e)
	{
		e.preventDefault();
		setUserEditFormValues($(this));
	});


	adminEditUsers.find('.fa-envelope').on('click', function(e)
	{
		e.preventDefault();
		if( ! confirm( 'Naozaj chcete odoslať konfirmačný email?' ) ) return;
		sendConfirmationEmail($(this));
	});

	/////////////////////////////////////////////////////////////
	/// Actions ////////////////////////////////////////////////
	///////////////////////////////////////////////////////////
	function blockUnblock( target )
	{
		let url = target.attr('href');

		sendPostRequest(url)
			.then(function( response ) {
				let data = response.data;
				if( data.success )
				{
					target.toggleClass('fa-check-circle').toggleClass('fa-minus-circle');
					target.closest('tr').toggleClass('bg-warning').toggleClass('text-light');
				}
				data.error ? showAlert(data.error, 'danger') : showAlert(data.success);
			})
			.catch(function( error ) {
				showAlert(error, 'danger');
			})
	}


	function setUserEditFormValues($this)
	{
		let roles = $this.data('roles');
		roles = roles ? roles.toString().split(',') : [];

		editUserForm[0].reset();
		editUserForm.find('option:selected').removeAttr('selected');

		editUserForm.find('#id').val($this.data('id'));
		editUserForm.find('#name').val($this.data('name'));
		editUserForm.find('#email').val($this.data('email'));

		_.forEach(roles, function( value ) {
			editUserForm.find('#role-' + value).attr('selected', 'selected');
			console.log('#role-' + value);
		});
	}


	function sendConfirmationEmail($this)
	{
		let url = $this.attr('href');

		showLoader();

		sendPostRequest(url)
			.then(function( response ) {
				let data = response.data;
				data.error ? showAlert(data.error, 'danger') : showAlert(data.success);
			})
			.catch(function( error ) {
				showAlert(error, 'danger');
			})
			.then(function() {
				hideLoader();
			})
	}
});