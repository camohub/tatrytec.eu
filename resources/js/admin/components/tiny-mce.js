
$(function(){
	if( window.tinymce )
	{
		let tinymceImageForm = $('#tinymceImageForm');
		let imageFileInput = $('#tinymceImage');
		let filePickerCallback = null;

		imageFileInput.on('change', function(e) {
			storeImage(e, $(this), filePickerCallback);
			imageFileInput[0].value = '';
		});


		tinymce.init({
			selector: ".tinymce",
			themes: "modern",
			entity_encoding: "raw",
			relative_urls: false,  // ie. if true file manager produce urls like ../../../../wrong.jpg
			image_advtab: true,
			image_class_list: [
				{ title: 'None', value: '' },
				{ title: 'Bootstrap fluid', value: 'img-fluid' },
				{ title: 'Left', value: 'fL' },
				{ title: 'Right', value: 'fR' },
				{ title: 'Gallery', value: 'gallery' }
			],
			plugins: [
				"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars advcode fullscreen insertdatetime media nonbreaking",
				"save table contextmenu directionality emoticons template paste textcolor"
			],
			content_css: "/css/tinymce-custom.css",
			style_formats: [
				{ title: "Headers", items: [
					{ title: "Header 1", format: "h2"},
					{ title: "Header 2", format: "h3"},
					{ title: "Header 3", format: "h4"}
				]},
				{ title: "Inline", items: [
					{ title: "Bold", icon: "bold", format: "bold"},
					{ title: "Italic", icon: "italic", format: "italic"},
					{ title: "Underline", icon: "underline", format: "underline"},
					{ title: "Strikethrough", icon: "strikethrough", format: "strikethrough"},
					{ title: "Superscript", icon: "superscript", format: "superscript"},
					{ title: "Subscript", icon: "subscript", format: "subscript"},
					{ title: "Code", icon: "code", format: "code"}
				]},
				{ title: "Blocks", items: [
					{ title: "Paragraph", format: "p"},
					{ title: "Blockquote", format: "blockquote"},
					{ title: "Div", format: "div"},
					{ title: "Pre", format: "pre"}
				]}
			],

			toolbar: "insertfile undo redo | styleselect | bold italic " +
			"| alignleft aligncenter alignright alignjustify " +
			"| bullist numlist | link image | media fullpage " +
			"| forecolor backcolor",

			//file_browser_callback: function (field_name, url, type, win)  // version 4
			file_picker_callback: function (callback, value, meta)
			{
				if(meta.filetype == 'image')
				{
					filePickerCallback = callback;
					imageFileInput.click();
				}
			}

		});

		function storeImage(e, $this, filePickerCallback)
		{
			let url = tinymceImageForm.attr('action');
			let headers = {'Content-Type': 'multipart/form-data'};
			let formData = new FormData();
			formData.append("image", $this[0].files[0]);

			sendPostRequest(url, formData, headers)
				.then(function( response ) {
					let data = response.data;
					console.log(data);
					filePickerCallback(data.filePath);
				})
				.catch(function( error ) {
					let data = error.response.data;
					console.log(data);
					let msg = 'Pri ukladaní obrázku došlo k chybe.';
					if( data.errors.image ) msg += '<br>' + data.errors.image[0];
					showAlert(msg, 'danger', true);
				});
		}
	}
});
