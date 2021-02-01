$( function()
{

	window.sendPostRequest = function sendPostRequest( url, data )
	{
		data = typeof data === 'undefined' ? {} : data;

		axios.defaults.headers.common['X-CSRF-TOKEN'] = $( 'meta[name="csrf-token"]' ).attr( 'content' );

		return axios.post(url, data);
	}

});