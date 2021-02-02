$( function()
{

	window.sendPostRequest = function sendPostRequest( url, data, headers )
	{
		data = typeof data === 'undefined' ? {} : data;
		headers = typeof headers === 'undefined' ? {} : headers;

		axios.defaults.headers.common['X-CSRF-TOKEN'] = $( 'meta[name="csrf-token"]' ).attr( 'content' );

		return axios.post(url, data, headers);
	}

});