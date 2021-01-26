$( function()
{
	$( document ).on( 'click', '.x', function()
	{
		$( this ).closest( 'div' ).css( 'display', 'none' );
	});

});

