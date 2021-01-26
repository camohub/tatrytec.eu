$( function()
{

	// Calling undefined function like in layoutSlim.latte which does not load prettyPrint causes an error.
	if ( typeof prettyPrint !== 'undefined' )
	{
		prettyPrint();
	}

} );