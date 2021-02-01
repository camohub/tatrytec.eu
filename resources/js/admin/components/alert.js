$(function(){

	let alertsWrapper = $('#alerts-wrapper');

	window.showAlert = function showAlert(data)
	{
		let type = data.error ? 'danger' : 'success';
		alertsWrapper.append(getAlertTemplate(type, data.success));

		$('div.alert').not('.alert-important').delay(5000).fadeOut(350);
	};


	function getAlertTemplate( type, msg, important )
	{
		important = !!typeof important === 'undefined';

		return `
			<div class="alert alert-${type} ${important ? 'important' : ''}" role="alert">
				${msg}
				${important ? `<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>` : ``}
			</div>
		`;
	}
});