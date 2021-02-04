$(function()
{
	//TODO: Toto by malo byť previazané cez ajax na ľavé menu.
	//$('#sideMenu').find( 'ul' ).css( 'display', 'block' );

	let adminEditMenu = $('#adminEditMenu');


	adminEditMenu.find('.editMenu').on('mousedown', function(e)
	{
		addItemsToUrl($(this));
	});


	adminEditMenu.find('.fa-trash-o').removeClass('d-none').on('click', function(e)
	{
		e.preventDefault();
		deleteCategory($(this));
	});


	adminEditMenu.find('.fa-check-circle, .fa-minus-circle').on('click', function(e)
	{
		e.preventDefault();
		changeCategoryVisibility($(this));
	});


	function addItemsToUrl($this)
	{
		let serialized = $('ul.sortable').sortableListsToString();
		let href = $this.attr('href');

		serialized = serialized.replace(/no-parent/g, '0');
		href = href.replace(/&menuItem[^&]+/g, '');  // If original url contains menuItems these have to be removed.

		$this.attr('href', href + '&' + serialized);  // Not need to solve ? cause links to handle methods always have do= param
	}


	function deleteCategory(target)
	{
		target.css('display', 'none');

		if( !confirm('Naozaj chcete položku zmazať?') ) return;

		showLoader();

		sendPostRequest()
			.then(function( response ) {
				showAlert('Kategória bola zmazaná.');
			})
			.catch(function( response ) {
				showAlert('Pri ukladaní údajov došlo k chybe.', 'error');
			})
			.then(function() {
				hideLoader();
				target.css('display', 'block');
			});
	}


	function changeCategoryVisibility(target)
	{
		showLoader();
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
			.then(function() {
				hideLoader();
			});
	}


	// Nette.ajax extensions ///////////////////////////////////////////

	let nette = {
		before: function (jqXHR, settings)
		{
			$('#editSection, #createSection').slideUp();
			$('.alert' ).fadeOut();
			$('#ajax-spinner').css( { 'display': 'block' } );
		},
		complete: function ( jqXHR, status, settings )
		{
			$('#sideMenu').find( 'ul' ).css( 'display', 'block' );
		}
	};

	// End of nette.ajax ///////////////////////////////////////////////



});



function activateEditForm(id, title, el)
{
	var editSection = $('#editSection');

	editSection.find('input[name=title]').val(title);
	editSection.find('input[name=id]').val(id);
	$('#createSection').css({'display' : 'none'});
	editSection.slideDown();
	editSection.offset({ left:editSection.offset().left, top:$(el).offset().top - 20 });  // must be after the slide cause display:none make some trouble

}


function activateCreateForm(el)
{
	var spinner = $( '#ajax-spinner' ).css( {'display':'block'} );

	$( '#createSelect' ).html( '' );

	/*$.nette.ajax({
			type: 'GET',
			url: {link select!},
			complete: function()
			{
				spinner.css( {'display' : 'none'} );
			}
		});*/

	var elOffset = $(el).offset(),
		createSection = $('#createSection');

	$('#editSection').css({'display' : 'none'});
	createSection.slideDown();
	createSection.offset({ left:elOffset.left, top:elOffset.top });  // must be after the slide cause display:none make some trouble

}