$( function() {

	var no_current = true;
	var side_menu = $( '#sideMenu' );
	var sidebarOpener = $( '.sidebar-opener' );

	side_menu.find( 'li' ).each( function()
	{
		if ( $( this ).attr( 'id' ) == category_id )  // category_id comes from menu.latte
		{
			$( this ).addClass( 'current_li' ).children( 'a' ).addClass( 'current' );
			$( this ).parents( 'li' ).addClass( 'current_li' );

			no_current = false;
		}
	} );

	sidebarOpener.click(function( e )
	{
		e.preventDefault();
		$(this).closest('li').find('ul').first().slideToggle();
	});

	//if( no_current ) side_menu.find( 'ul' ).css( 'display', 'block' );

});

