$(function(){

	let alertsWrapper = $('#alerts-wrapper');

	window.showAlert = function showAlert(msg, type, important)
	{
		type = typeof type === 'undefined' || type == 'success' ? 'success' : 'danger';  // error => danger
		important = typeof important === 'undefined' ? false : !!important;

		alertsWrapper.append(getAlertTemplate(msg, type, important));

		$('div.alert').not('.alert-important').delay(5000).fadeOut(350);
	};


	function getAlertTemplate( msg, type, important )
	{
		return `
			<div class="alert alert-${type} ${important ? 'alert-important' : ''}" role="alert">
				${important ? `<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>` : ``}
				${msg}
			</div>
		`;
	}
});