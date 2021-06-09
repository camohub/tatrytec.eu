window.$ = window.jQuery = require('jquery');

$( function()
{

	setTimeout( function()
	{
		$( '.translateInit' ).removeClass( 'translateInit' );
		$( '.translateInit-2' ).removeClass( 'translateInit-2' );
		$( '.translateInit-3' ).removeClass( 'translateInit-3' );
		$( '.translateInit-4' ).removeClass( 'translateInit-4' );
	}, 50 );

});