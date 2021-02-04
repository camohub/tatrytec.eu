
<div class="col-xs-12" id="sortableCategoriesWrapper">

	@include('admin.categories.components.sortable-categories-item', ['categories' => $categories])

	{{-- Script is in snippet cause ajax renders new list without active sortableLists --}}
	<script>
		window.addEventListener('load', (event) => {
			console.log($( '.sortable' ));
			$( '.sortable' ).sortableLists( {
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
		});

	</script>

</div>