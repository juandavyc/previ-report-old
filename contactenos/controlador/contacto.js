

$("#form_contacto_cliente").on('submit', (function (e) {
	//serializa el formulario para agarrar todos los input,selects...
	var result = {};
	$.each($('#form_contacto_cliente').serializeArray(), function () {
		result[this.name] = this.value;
	});
	// abre una ventana de dialogo
	$.confirm({
		title: "Error ",
		content: "Cargando, espere...",
		typeAnimated: true,
		scrollToPreviousElement: false,
		scrollToPreviousElementAnimate: false,

		content: function () {
			//controlar el primer modal
			var self = this;
			return $.ajax({
				url: "/contactenos/modelo/contacto.php",
				type: "POST",
				data: result,
				headers: {
					'csrf-token': $('meta[name="csrf-token"]').attr('content'),
				},
				dataType: 'json',
				timeout: 5000,
			}).done(function (response) {

				console.log(response);
				if (response.status === "BIEN") {
					self.setTitle('Informacion guardada!');
					self.setContentAppend(response.message);
					$('#form_contacto_cliente').trigger("reset");
				}

				else {
					self.setTitle('Error!');
					self.setContentAppend(response.message);
				}
			}).fail(function (response) {

				console.log(response);

			});
		},
		buttons: {
			aceptar: function () {

			}
		}
	});

	e.preventDefault();
	return false;
}));

