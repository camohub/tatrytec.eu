$( function()
{
	window.sendPostRequest = function sendPostRequest( url, data, headers )
	{
		data = typeof data === 'undefined' ? {} : data;
		headers = typeof headers === 'undefined' ? {} : headers;

		// bootstrap.js contains X-CSRF-TOKEN header 
		//axios.defaults.headers.common['X-CSRF-TOKEN'] = $( 'meta[name="csrf-token"]' ).attr( 'content' );

		return axios.post(url, data, headers);  // Return promise
	};


	let ajaxLoader = $('#ajax-loader');

	// Use it when you ned not on every request.
	window.showLoader = function()
	{
		ajaxLoader.css('display', 'block');
	};

	window.hideLoader = function()
	{
		ajaxLoader.css('display', 'none');
	};

});