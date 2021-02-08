$(function()
{
	//TODO: Toto by malo byť previazané cez ajax na ľavé menu.
	//$('#sideMenu').find( 'ul' ).css( 'display', 'block' );

	let adminEditMenu = $('#adminEditMenu');
	let categoryEditForm = $('#editCategoryForm');
	let sortableList = $('.sortable');


	sortableList.sortableLists( {
		placeholderCss: {
			'background-color': '#fffdc7', 'border': '2px solid #b5e9e3'
		},
		hintCss: {
			'background-color': '#c1ffc0', 'border': '2px solid #b5e9e3'
		},
		ignoreClass: 'ignore',
		opener: {
			active: true,
			as: 'html',  // or "class" or skip if using background-image url
			close: '<i class="fa fa-minus c7"></i>', // or 'fa fa-minus' or './imgs/Remove2.png'
			open: '<i class="fa fa-plus c3"></i>', // or 'fa fa-plus' or './imgs/Add2.png'
			openerCss: {
				'margin-bottom': '7px',
				'margin-right': '7px',
				'cursor': 'pointer'
			}
		}
	} );


	adminEditMenu.find('.editSort').on('mousedown', function(e)
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


	adminEditMenu.find('.fa-pencil').on('click', function(e)
	{
		e.preventDefault();
		let name = $(this).data('name');
		let id = $(this).data('id');
		let parent_id = $(this).data('parent_id');

		setCategoriesEditFormValues(name, id, parent_id);
	});



	function addItemsToUrl($this)
	{
		let serialized = $('ul.sortable').sortableListsToString();
		let href = $this.attr('href');

		serialized = serialized.replace(/no-parent/g, '0');
		href = href.replace(/&menuItem[^&]+/g, '');  // If original url contains menuItems these have to be removed.

		$this.attr('href', href + (href.indexOf('?') === -1 ? '?' : '&') + serialized);
	}


	function deleteCategory(target)
	{
		if( !confirm('Naozaj chcete položku zmazať?') ) return;

		target.css('display', 'none');
		showLoader();
		let url = target.attr('href');

		sendPostRequest(url)
			.then(function( response ) {
				showAlert('Kategória bola zmazaná.');
				let ul = target.closest('ul');
				target.closest('li').remove();
				if( !ul.find('li').length )  // Has to be after li.remove()
				{
					ul.closest('li').find('.s-l-opener').remove();
					ul.remove();
				}
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
				showAlert('Pri ukladaní údajov došlo k chybe.', 'error');
			})
			.then(function() {
				hideLoader();
			});
	}


	function setCategoriesEditFormValues( name, id, parent_id )
	{
		categoryEditForm.find('#name').val(name);
		categoryEditForm.find('#id').val(id);
		categoryEditForm.find('#parentId').val(parent_id);
	}

});
